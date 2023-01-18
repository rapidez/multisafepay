# Rapidez MultiSafePay

## Requirements

You need the [MultiSafePay Magento 2](https://github.com/MultiSafepay/Magento2) and [MultiSafePay Magento 2 GraphQL](https://github.com/MultiSafepay/magento2-graphql) modules installed in your Magento 2 installation.

## Installation

```
composer require rapidez/multisafepay
```

And import the JS into your `resources/js/app.js`:

```
import 'Vendor/rapidez/multisafepay/resources/js/multisafepay.js';
```

Then, in your magento -> configuration -> multisafepay -> general settings, enable custom return urls for PWA and use the following return URLs:

```
[your base rapidez url]/msp-return/cancel?quoteId={{quote.masked_id}}
[your base rapidez url]/msp-return/success?secureToken={{secure_token}}&orderId={{order.increment_id}}&paymentCode={{payment.code}}
```

## Views

You can publish the views with the following command:

```
php artisan vendor:publish --provider="Rapidez\MultiSafePay\MultiSafePayServiceProvider" --tag=views
```
