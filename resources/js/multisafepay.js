import MSPPending from './components/MSPPending.vue'
Vue.component('msp-pending', MSPPending)

document.addEventListener('turbolinks:load', () => {
    window.app.$on('checkout-payment-saved', (data) => {
        if (!data.order.payment_method_code.includes('multisafepay_')) {
            return;
        }
        window.app.checkout.doNotGoToTheNextStep = true

        let headers = { Authorization: `Bearer ${localStorage.token}` }

        let cart = window.app.user ? 'mine' : localStorage.mask;
        magento.get('/multisafepay/' + cart + '/payment-url/' + data.order.id, { headers: headers }).then(response => {
            window.location.replace(response.data);
        });
    });
})
