<?php

namespace CaliforniaMountainSnake\PhpYandexPayment\HttpPaymentNotice;

use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataArrayIsEmptyException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataParamNotFoundException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentInvalidHashException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentIsUnacceptedException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentWithCodeproException;

/**
 * Класс обработки и проверки на корректность пришедшего HTTP-уведомления о платеже.
 * Не имеет зависимостей, может быть использован в любом другом коде.
 */
class YandexHttpPaymentNotice
{
    use GettersTrait;
    use ChecksTrait;

    /**
     * Массив с данными уведомления. $_POST.
     * @var array
     */
    protected $data;

    /**
     * Секретное слово яндекс-кошелька для проверки подлинности HTTP-уведомлений.
     * @var string
     */
    protected $yandexSecretHttpNoticeToken;

    /**
     * Проведены ли все проверки пришедшего уведомления?
     * @var bool
     */
    protected $isChecked = false;

    /**
     * PaymentHttpNotice constructor.
     * @param array $_post_array_width_payment_data
     * @param string $_yandex_secret_http_notice_token
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    public function __construct(array $_post_array_width_payment_data, string $_yandex_secret_http_notice_token)
    {
        // Инициализируем параметры.
        $this->data                        = $_post_array_width_payment_data;
        $this->yandexSecretHttpNoticeToken = $_yandex_secret_http_notice_token;

        // Проверяем платеж на ошибки.
        $this->checkErrors();
    }

    /**
     * Получить значение из массива данных уведомления.
     *
     * @param string $_identifier Идентификатор нужного значения.
     * @return mixed Значение. Может иметь различный тип данных.
     * @throws PaymentDataParamNotFoundException
     */
    protected function getDataParam(string $_identifier)
    {
        if (!isset ($this->data[$_identifier])) {
            throw new PaymentDataParamNotFoundException ('Identifier "' . $_identifier
                . '" not found in the notice data array!');
        }

        return $this->data[$_identifier];
    }

    /**
     * @return array
     */
    protected function getPaymentData(): array
    {
        return $this->data;
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    protected function checkErrors(): void
    {
        // Проверим, не прислали ли пустое уведомление.
        $this->checkIsDataArrayEmpty();

        // Проверяем, завершен ли платеж. Не платеж ли это с протекцией или доп-действиями.
        $this->checkIsFinal();

        // Проверяем хеш уведомления.
        $this->checkHash();
    }
}
