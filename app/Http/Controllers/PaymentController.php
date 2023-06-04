<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    private \Omnipay\Common\GatewayInterface $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(string $id)
    {
        return "hello";
        // dd($id);
        // try {

        //     $response = $this->gateway->purchase(array(
        //         'amount' => 10,
        //         'currency' => "USD",
        //         'returnUrl' => url('success'),
        //         'cancelUrl' => url('error')
        //     ))->send();

        //     if ($response->isRedirect()) {
        //         $response->redirect();
        //     }
        //     else{
        //         return $response->getMessage();
        //     }

        // } catch (\Throwable $th) {
        //     return $th->getMessage();
        // }

        // return 'Payment is successfull. Your Transaction ID is:'. $response->getTransactionReference();
    }

    public function success(Request $request): ?string
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $arr = $response->getData();

                $payment = new Payment();
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];

                $payment->save();

                return "Payment is Successfull. Your Transaction Id is : " . $arr['id'];

            }
            else{
                return $response->getMessage();
            }
        }
        else{
            return 'Payment declined!!';
        }
    }

    public function error(): string
    {
        return 'User declined the payment!';
    }

}
