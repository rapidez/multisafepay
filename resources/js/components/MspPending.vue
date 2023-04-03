<script>
    export default {
        props: {
            order: Object
        },

        data() {
            return {
                completed: false,
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
                magento.get(`/multisafepay/orders/${this.order.increment_id}/${this.order.secure_token}`).then(response => {
                    if(['processing', 'success'].includes(response.data?.status)) {
                        this.completed = true;
                    } else {
                        window.setTimeout(this.checkStatus, 2000);
                    }
                })
            }
        },
    }
</script>
