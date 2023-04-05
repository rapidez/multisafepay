# Rapidez MultiSafePay

## Requirements

You need the [MultiSafePay Magento 2](https://github.com/MultiSafepay/Magento2) and [MultiSafePay Magento 2 GraphQL](https://github.com/MultiSafepay/magento2-graphql) modules installed in your Magento 2 installation.

### Temporary notice

The magento2 core package from MultiSafePay currently contains a bug that prevents guest checkout from working. You can use [version 2.19.1 from this fork](https://github.com/Jade-GG/magento2-core) until the PR fixing this has been merged into the official repository.

## Installation

```bash
composer require rapidez/multisafepay
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

## Development note

When you're developing using the MultiSafePay API in testing environments, you might run into the issue that the API returns an empty payment URL. This happens when you try to make an order with an Order ID that already exists in your MultiSafePay testmerchant account, which is common if you use the same site ID on different environments.

To avoid this issue, make sure that every individual environment has its own individual site in your testmerchant account.