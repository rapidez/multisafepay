<script>
    export default {
        data() {
            return {
                completed: false,
                order: {},
            }
        },

        mounted() {
            this.order.customer_email = window.localStorage.email;
            this.checkStatus();
        },

        render() {
            return this.$scopedSlots.default({
                completed: this.completed,
                order: this.order
            })
        },

        methods: {
            async checkStatus() {
                this.params = Object.fromEntries(new URLSearchParams(window.location.search).entries());
                let token = this.params.secureToken ?? null;
                let orderId = this.params.orderId ?? null;
                if(!token || !orderId) {
                    return;
                }

                magento.get(`/multisafepay/orders/${orderId}/${token}`).then(response => {
                    if(['processing', 'success'].includes(response.data?.status)) {
                        this.completed = true;
                        this.order = {
                            increment_id: orderId,
                            payment_method: response.data.payment.method,
                            shipping_method: response.data.shipping_description,
                            email: response.data.customer_email,
                        }
                    } else {
                        window.setTimeout(this.checkStatus, 2000);
                    }
                })
            }
        },
    }
</script>
