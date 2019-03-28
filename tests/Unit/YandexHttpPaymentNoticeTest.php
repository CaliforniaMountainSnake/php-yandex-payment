<?php

namespace Tests\Unit;

use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataArrayIsEmptyException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataParamNotFoundException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentInvalidHashException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentIsUnacceptedException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentWithCodeproException;
use CaliforniaMountainSnake\PhpYandexPayment\HttpPaymentNotice\YandexHttpPaymentNotice;
use PHPUnit\Framework\TestCase;
use Tests\TestValues\YandexPaymentValues;

class YandexHttpPaymentNoticeTest extends TestCase
{
    use YandexPaymentValues;

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSuccessfulPayment_1(): void
    {
        try {
            $notice = new YandexHttpPaymentNotice(
                $this->getSuccessfulPaymentArray_1_CardIncoming_2_rubbles(),
                $this->getSecretHttpNoticeToken()
            );

            $this->assertEquals('test@com.com', $notice->getEmail());

        } catch (PaymentException $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function testPaymentDataArrayIsEmptyException(): void
    {
        $this->expectException(PaymentDataArrayIsEmptyException::class);

        new YandexHttpPaymentNotice(
            [],
            $this->getSecretHttpNoticeToken()
        );
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function testPaymentDataParamNotFoundException(): void
    {
        $payment = $this->getSuccessfulPaymentArray_1_CardIncoming_2_rubbles();
        unset ($payment['sender']);

        $this->expectException(PaymentDataParamNotFoundException::class);

        new YandexHttpPaymentNotice(
            $payment,
            $this->getSecretHttpNoticeToken()
        );
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function testPaymentInvalidHashException(): void
    {
        $payment           = $this->getSuccessfulPaymentArray_1_CardIncoming_2_rubbles();
        $payment['amount'] = 5000;

        $this->expectException(PaymentInvalidHashException::class);

        new YandexHttpPaymentNotice(
            $payment,
            $this->getSecretHttpNoticeToken()
        );
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function testPaymentIsUnacceptedException(): void
    {
        $payment               = $this->getSuccessfulPaymentArray_1_CardIncoming_2_rubbles();
        $payment['unaccepted'] = true;

        $this->expectException(PaymentIsUnacceptedException::class);

        new YandexHttpPaymentNotice(
            $payment,
            $this->getSecretHttpNoticeToken()
        );
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function testBadSecret(): void
    {
        $this->expectException(PaymentInvalidHashException::class);

        new YandexHttpPaymentNotice(
            $this->getSuccessfulPaymentArray_1_CardIncoming_2_rubbles(),
            'bad_secret'
        );
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function testPaymentWithCodeproException(): void
    {
        $payment            = $this->getSuccessfulPaymentArray_1_CardIncoming_2_rubbles();
        $payment['codepro'] = true;

        $this->expectException(PaymentWithCodeproException::class);

        new YandexHttpPaymentNotice(
            $payment,
            $this->getSecretHttpNoticeToken()
        );
    }
}
