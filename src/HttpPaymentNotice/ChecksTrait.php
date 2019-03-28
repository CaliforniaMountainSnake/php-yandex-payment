<?php

namespace CaliforniaMountainSnake\PhpYandexPayment\HttpPaymentNotice;

use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataArrayIsEmptyException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentDataParamNotFoundException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentInvalidHashException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentIsUnacceptedException;
use CaliforniaMountainSnake\PhpYandexPayment\Exceptions\PaymentWithCodeproException;

/**
 * Различные проверки пришедшего уведомления.
 */
trait ChecksTrait
{
    /**
     * @param string $_identifier Идентификатор нужного значения.
     * @return mixed Значение. Может иметь различный тип данных.
     * @throws PaymentDataParamNotFoundException
     */
    abstract protected function getDataParam(string $_identifier);

    /**
     * @return array
     */
    abstract protected function getPaymentData(): array;

    /**
     * @return string
     * @throws PaymentDataParamNotFoundException
     */
    protected function getNoticeHash(): string
    {
        $str = $this->getDataParam('notification_type')
            . '&' . $this->getDataParam('operation_id')
            . '&' . $this->getDataParam('amount')
            . '&' . $this->getDataParam('currency')
            . '&' . $this->getDataParam('datetime')
            . '&' . $this->getDataParam('sender')
            . '&' . $this->getDataParam('codepro')
            . '&' . $this->yandexSecretHttpNoticeToken
            . '&' . $this->getDataParam('label');

        return \sha1($str);
    }

    /**
     * @throws PaymentDataArrayIsEmptyException
     */
    protected function checkIsDataArrayEmpty(): void
    {
        if (empty ($this->getPaymentData())) {
            throw new PaymentDataArrayIsEmptyException ('NoticeDataArray array is empty!');
        }
    }

    /**
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentIsUnacceptedException
     * @throws PaymentWithCodeproException
     */
    protected function checkIsFinal(): void
    {
        if ($this->getDataParam('unaccepted') === true) {
            /*
             * Если unaccepted=true, то перевод еще не зачислен на счет получателя.
             * Чтобы его принять, получателю нужно совершить дополнительные действия.
             * Например, освободить место на счете, если достигнут лимит доступного остатка
             * (https://money.yandex.ru/doc.xml?id=524834&lang=ru).
             * Или указать код протекции, если он необходим для получения перевода.
             */
            throw new PaymentIsUnacceptedException('Current payment is unaccepted!');
        }

        if ($this->getDataParam('codepro') === true) {
            /*
             * Если codepro=true, то перевод защищен кодом протекции.
             * Чтобы получить такой перевод, пользователю необходимо ввести код протекции.
             */
            throw new PaymentWithCodeproException ('Current payment is with codepro!');
        }
    }

    /**
     * @throws PaymentDataParamNotFoundException
     * @throws PaymentInvalidHashException
     */
    protected function checkHash(): void
    {
        $needHash    = $this->getDataParam('sha1_hash');
        $currentHash = $this->getNoticeHash();
        if ($currentHash !== $needHash) {
            throw new PaymentInvalidHashException ('Current notice hash (' . $currentHash
                . ') is not equal to given from yandex hash (' . $needHash . ')!');
        }
    }
}
