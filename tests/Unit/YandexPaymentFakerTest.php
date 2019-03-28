<?php

namespace Tests\Unit;

use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentException;
use CaliforniaMountainSnake\PhpYandexPayment\HttpPaymentNotice\YandexHttpPaymentNotice;
use PHPUnit\Framework\TestCase;
use Tests\TestValues\YandexPaymentFaker;

class YandexPaymentFakerTest extends TestCase
{
    use YandexPaymentFaker;

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function test_1(): void
    {
        $secretToken    = 'any token';
        $amount         = 150;
        $withdrawAmount = 155;
        $currency       = 600;
        $label          = 'any label';

        $fakePayment1 = $this->fakeYandexPayment($secretToken, $amount, $currency, $label, $withdrawAmount);

        try {
            $notice = new YandexHttpPaymentNotice(
                $fakePayment1,
                $secretToken
            );

            $this->assertEquals($label, $notice->getLabel());
        } catch (PaymentException $e) {
            $this->assertTrue(false);
        }
    }
}
