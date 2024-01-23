<?php

namespace Modules\Payment;

use Modules\Payment\DTO\PaymentDetails;
use Modules\Payment\DTO\SuccessfulPaymentResponse;
use Modules\Payment\Enums\PaymentProvider;

interface PaymentGatway
{
    public function charge(PaymentDetails $paymentDetails): SuccessfulPaymentResponse;
    public function id(): PaymentProvider;
}