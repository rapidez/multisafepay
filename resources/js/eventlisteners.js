import { addAfterPlaceOrderHandler } from 'Vendor/rapidez/core/resources/js/stores/usePaymentHandlers'

addAfterPlaceOrderHandler(async function (response, mutationComponent) {
    mutationComponent.redirect = response?.data?.placeOrder?.orderV2.multisafepay_payment_url || mutationComponent.redirect;
});
