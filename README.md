# php-yandex-payment
This is a simple php library for handling Yandex.Money payments!


## Install:
### Require this package with Composer
Install this package through [Composer](https://getcomposer.org/).
Edit your project's `composer.json` file to require `californiamountainsnake/php-yandex-payment`:
```json
{
    "name": "yourproject/yourproject",
    "type": "project",
    "require": {
        "php": "^7.3.1",
        "californiamountainsnake/php-yandex-payment": "*"
    }
}
```
and run `composer update`

### or
run this command in your command line:
```bash
composer require californiamountainsnake/php-yandex-payment
```

## Usage examples:
```php
<?php
use CaliforniaMountainSnake\PhpYandexPayment\HttpPaymentNotice\YandexHttpPaymentNotice;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentException;

try {
    $secretToken = 'your_secret_yandex_http_notice_token';
    $notice = new YandexHttpPaymentNotice($_POST, $secretToken);
} catch (PaymentException $e) {
    return $e->getMessage();
}

// If we didn't get exceptions above it means that a payment is correct and we can get payment details.
$notice->getAmount();
$notice->getCurrency();
$notice->getLabel();

```
