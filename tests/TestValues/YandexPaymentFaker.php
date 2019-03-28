<?php

namespace Tests\TestValues;

trait YandexPaymentFaker
{
    /**
     * Создать фейковый платеж, который пройдет проверку безопасности на клиенте с таким же секретным токеном.
     *
     * Необязательные параметры не входят в проверку хеша, поэтому МОГУТ БЫТЬ ЛЮБЫМИ, платеж сохранит свою корректность.
     *
     * @param string $_yandex_secret_http_notice_token
     * @param float $_amount
     * @param int $_currency
     * @param string $_label
     * @param string $_withdraw_amount
     * @return array
     */
    public function fakeYandexPayment(
        string $_yandex_secret_http_notice_token,
        float $_amount,
        int $_currency,
        string $_label,
        string $_withdraw_amount = '99.00'
    ): array {
        $notification_type = 'card-incoming';
        $operation_id      = '999999999999999';
        $datetime          = '2019-02-21T21:26:02Z';
        $sender            = '';
        $codepro           = 'false';

        $sha1_hash = $this->makeNoticeHash($_yandex_secret_http_notice_token, $notification_type, $operation_id,
            $_amount, $_currency, $datetime, $sender, $codepro, $_label);

        return [
            'notification_type' => $notification_type,
            'zip' => '',
            'amount' => $_amount,
            'firstname' => '',
            'codepro' => $codepro,
            'withdraw_amount' => $_withdraw_amount,
            'city' => '',
            'unaccepted' => 'false',
            'label' => $_label,
            'building' => '',
            'lastname' => '',
            'datetime' => $datetime,
            'suite' => '',
            'sender' => $sender,
            'phone' => '',
            'sha1_hash' => $sha1_hash,
            'street' => '',
            'flat' => '',
            'fathersname' => '',
            'operation_label' => '24012b0f-0011-5000-8000-18df823cd29b',
            'operation_id' => $operation_id,
            'currency' => $_currency,
        ];
    }

    /**
     * Make notice "sha1_hash" parameter.
     *
     * @param string $_yandex_secret_http_notice_token
     * @param string $_notification_type
     * @param string $_operation_id
     * @param string $_amount
     * @param string $_currency
     * @param string $_datetime
     * @param string $_sender
     * @param string $_codepro
     * @param string $_label
     * @return string
     */
    protected function makeNoticeHash(
        string $_yandex_secret_http_notice_token,
        string $_notification_type,
        string $_operation_id,
        string $_amount,
        string $_currency,
        string $_datetime,
        string $_sender,
        string $_codepro,
        string $_label
    ): string {
        $str = $_notification_type
            . '&' . $_operation_id
            . '&' . $_amount
            . '&' . $_currency
            . '&' . $_datetime
            . '&' . $_sender
            . '&' . $_codepro
            . '&' . $_yandex_secret_http_notice_token
            . '&' . $_label;

        return \sha1($str);
    }
}
