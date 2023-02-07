# Rapidez MultiSafePay

## Requirements

You need the [MultiSafePay Magento 2](https://github.com/MultiSafepay/Magento2) and [MultiSafePay Magento 2 GraphQL](https://github.com/MultiSafepay/magento2-graphql) modules installed in your Magento 2 installation.

### Temporary notice

The magento2 core package from MultiSafePay currently contains a bug that prevents guest checkout from working. You can use [version 2.19.1 from this fork](https://github.com/Jade-GG/magento2-core) until the PR fixing this has been merged into the official repository.

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

Finally, note that MultiSafePay needs these magento URLs to work:

```
[your base magento url]/multisafepay/connect/success?[...]
[your base magento url]/multisafepay/connect/cancel?[...]
[your base magento url]/multisafepay/connect/notification?[...]
```

You will have to update your deployment to open up these specific URLs (i.e. to not redirect these to your rapidez frontend).  
For example, for a standard rapidez installation you can update the regex as seen in the [Rapidez docs deployment page](https://docs.rapidez.io/0.x/deployment.html#redirecting-magento-to-rapidez) to include `multisafepay`.

## Views

You can publish the views with the following command:

```
php artisan vendor:publish --provider="Rapidez\MultiSafePay\MultiSafePayServiceProvider" --tag=views
```