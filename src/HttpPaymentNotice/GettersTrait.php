<?php

namespace CaliforniaMountainSnake\PhpYandexPayment\HttpPaymentNotice;

use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataParamNotFoundException;

/**
 * Геттеры информации о платеже.
 * Следует иметь возможность получать ТОЛЬКО столбцы, используемые при расчете хеша платежа,
 * ибо все остальные можно легко подменить, сохранив корректность платежа.
 */
trait GettersTrait
{
    /**
     * @param string $_identifier Идентификатор нужного значения.
     * @return mixed Значение. Может иметь различный тип данных.
     * @throws PaymentDataParamNotFoundException
     */
    abstract protected function getDataParam(string $_identifier);

    /**
     * Get email. !!!WARNING!!! This is a not secured parameter.
     *
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    public function getEmail(): string
    {
        return $this->getDataParam('email');
    }

    /**
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    public function getNotificationType(): string
    {
        return $this->getDataParam('notification_type');
    }

    /**
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    public function getOperationId(): string
    {
        return $this->getDataParam('operation_id');
    }

    /**
     * @return float
     * @throws PaymentDataParamNotFoundException
     */
    public function getAmount(): float
    {
        return (float)$this->getDataParam('amount');
    }

    /**
     * @return int
     * @throws PaymentDataParamNotFoundException
     */
    public function getCurrency(): int
    {
        return (int)$this->getDataParam('currency');
    }

    /**
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    public function getDatetime(): string
    {
        return $this->getDataParam('datetime');
    }

    /**
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    public function getSender(): string
    {
        return $this->getDataParam('sender');
    }

    /**
     * @return bool
     * @throws PaymentDataParamNotFoundException
     */
    public function getCodepro(): bool
    {
        return (bool)$this->getDataParam('codepro');
    }

    /**
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    public function getLabel(): string
    {
        return $this->getDataParam('label');
    }
}
