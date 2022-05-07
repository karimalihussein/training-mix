<?php


namespace App\Services;


interface PaymentGatwayContract
{
    public function setDiscount($amount) : void;
    public function charge($amount) : array;
}