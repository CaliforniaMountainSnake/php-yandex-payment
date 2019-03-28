<?php

namespace Tests\TestValues;

trait YandexPaymentValues
{
    public function getSecretHttpNoticeToken(): string
    {
        return 'RDYPwGWXAj0+PZUIO7w98ehE';
    }

    public function getSuccessfulPaymentArray_1_CardIncoming_2_rubbles(): array
    {
        return [
            'notification_type' => 'card-incoming',
            'zip' => '',
            'amount' => '1.96',
            'firstname' => '',
            'codepro' => 'false',
            'withdraw_amount' => '2.00',
            'city' => '',
            'unaccepted' => 'false',
            'label' => '',
            'building' => '',
            'lastname' => '',
            'datetime' => '2019-02-21T21:26:02Z',
            'suite' => '',
            'sender' => '',
            'phone' => '',
            'sha1_hash' => '1d6bd549d656521ae7cd9a5dc3f94e4881e76b01',
            'street' => '',
            'flat' => '',
            'fathersname' => '',
            'operation_label' => '24012b0f-0011-5000-8000-18df823cd29b',
            'operation_id' => '604099562882008012',
            'currency' => '643',
            'email' => 'test@com.com',
        ];
    }
}
