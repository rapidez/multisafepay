import { addAfterPlaceOrderHandler } from 'Vendor/rapidez/core/resources/js/stores/usePaymentHandlers'

addAfterPlaceOrderHandler(async function (response, mutationComponent) {
    mutationComponent.redirectUrl = response?.data?.placeOrder?.orderV2?.multisafepay_payment_url || mutationComponent.redirectUrl;
});
