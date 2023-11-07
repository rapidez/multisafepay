<script>
    import { mask as useMask } from 'Vendor/rapidez/core/resources/js/stores/useMask'
    import { token as useToken } from 'Vendor/rapidez/core/resources/js/stores/useUser'

    export default {
        props: {
            token: {
                type: String,
                default: useToken.value,
            },
            mask: {
                type: String,
                default: useMask.value,
            },
        },

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
                    if(['processing', 'success', 'complete'].includes(response.data?.status)) {
                        useToken.value = this.token;
                        useMask.value = this.mask;

                        this.completed = true;
                        this.order = Object.assign({
                            sales_order_items: response.data.items,
                            sales_order_payments: [response.payment],
                        }, response.data)
                    } else {
                        window.setTimeout(this.checkStatus, 2000);
                    }
                })
            }
        },
    }
</script>
