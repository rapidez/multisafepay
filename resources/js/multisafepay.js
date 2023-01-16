import axios from "axios";

document.addEventListener('turbolinks:load', () => {
    window.app.$on('checkout-credentials-saved', () => {
        let headers = { Authorization: `Bearer ${localStorage.token}` }
        if (window.config.store_code) {
            headers['Store'] = window.config.store_code
        }

        axios.post(config.magento_url + '/graphql', {
            query: '{ customerCart { id } }'
        }, {
            headers: headers
        }).then(response => {
            window.app.checkout.cart_id = response.data.data.customerCart.id;
        });
    })
    window.app.$on('checkout-payment-saved', (data) => {
        if (!data.order.payment_method_code.includes('multisafepay_')) {
            return;
        }
        window.app.checkout.doNotGoToTheNextStep = true

        let headers = { Authorization: `Bearer ${localStorage.token}` }
        if (window.config.store_code) {
            headers['Store'] = window.config.store_code
        }

        axios.post(config.magento_url + '/graphql', {
            query:
            `mutation placeOrder($cartId: String!){
                placeOrder(input: { cart_id: $cartId }) {
                    order {
                        order_number
                        multisafepay_payment_url {
                            payment_url
                            error
                        }
                    }
                }
            }`,
            variables: {
                cartId: window.app.checkout.cart_id
            }
        }, {
            headers: headers
        }).then(response => {
            if(response.data.errors) {
                window.Notify(`Checkout error|${response.data.errors[0].message}`, "error");
            } else {
                window.location.replace(response.data.data.placeOrder.order.multisafepay_payment_url.payment_url)
            }
        });
    });
})
