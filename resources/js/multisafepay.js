import axios from "axios";

document.addEventListener('turbolinks:load', () => {
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
            `query {
                customer {
                    orders ( filter: { number: { eq: "${ (data.order.id+'').padStart(9, '0') }" } } )
                    {
                        items {
                            multisafepay_payment_url
                        }
                    }
                }
            }`,
        }, {
            headers: headers
        }).then(response => {
            if(response.data.errors) {
                window.Notify(`Checkout error|${response.data.errors[0].message}`, "error");
            } else {
                window.location.replace(response.data.data.customer.orders.items[0].multisafepay_payment_url);
            }
        });
    });
})
