import MSPPending from './components/MSPPending.vue'
Vue.component('msp-pending', MSPPending)

document.addEventListener('turbo:load', () => {
    window.app.$on('checkout-payment-saved', (data) => {
        if (!data.order.payment_method_code.includes('multisafepay_')) {
            return;
        }
        window.app.checkout.doNotGoToTheNextStep = true
        let cart = window.app.user ? 'mine' : localStorage.mask;
        magentoUser.get(`/multisafepay/${cart}/payment-url/${data.order.id}`).then(response => {
            window.location.replace(response.data);
        });
    });
})
