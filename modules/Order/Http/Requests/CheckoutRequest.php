<?php

declare(strict_types=1);

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CheckoutRequest extends FormRequest
{
    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:modules_products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_token' => 'required|string',
        ];
    }
}
