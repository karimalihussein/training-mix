<?php

namespace Modules\Payment;

use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\DTO\PaymentDetails;
use Modules\Payment\DTO\SuccessfulPaymentResponse;
use Modules\Payment\Enums\PaymentProvider;
use RuntimeException;

final class PayBuddyGetway implements PaymentGatway
{
    public function __construct(
        protected PayBuddySDK $payBuddySDK
    ) {
    }

    /**
     * @param PaymentDetails $details
     * @throws PaymentFailedException
     * @return SuccessfulPaymentResponse
     */
    public function charge(PaymentDetails $details): SuccessfulPaymentResponse
    {
        try {
            $charge = $this->payBuddySDK->charge(
                token: $details->token,
                amountInCents: $details->amountInCents,
                statementDescription: $details->statementDescription,
            );
        } catch (RuntimeException $exception) {
            throw new PaymentFailedException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        return new SuccessfulPaymentResponse(
            id: $charge['id'],
            amountInCents: $charge['amount_in_cents'],
            paymentProvider: self::id(),
        );
    }

    public function id(): PaymentProvider
    {
        return PaymentProvider::PayBuddy;
    }
}