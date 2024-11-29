document.addEventListener('vue:loaded', () => {
    window.app.$on('checkout-payment-saved', (data) => {
        if (!data.order.payment_method_code.includes('multisafepay_')) {
            return;
        }
        window.app.checkout.doNotGoToTheNextStep = true
        let cart = window.app.user?.id ? 'mine' : localStorage.mask;
        window.magentoAPI('get', `multisafepay/${cart}/payment-url/${data.order.id}`).then(response => {
            window.location.replace(response);
        });
    });
})
