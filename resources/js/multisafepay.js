import MSPPending from './components/MSPPending.vue'
Vue.component('msp-pending', MSPPending)

document.addEventListener('turbo:load', () => {
    window.app.$on('checkout-payment-saved', (data) => {
        if (!data.order.payment_method_code.includes('multisafepay_')) {
            return;
        }
        window.app.checkout.doNotGoToTheNextStep = true
        let cart = window.app.user ? 'mine' : localStorage.mask;

        let waitForURL = function(cartId, orderId) {
            magentoUser.get(`/multisafepay/${cartId}/payment-url/${orderId}`).then(response => {
                if(response.data) {
                    window.location.replace(response.data);
                } else {
                    window.setTimeout(() => waitForURL(cartId, orderId), 1000);
                }
            });
        }

        waitForURL(cart, data.order.id);
    });
})
