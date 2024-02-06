<?php

declare(strict_types=1);

namespace Modules\Booking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:modules_customers,email',
            'phone_number' => 'required|string|unique:modules_customers,phone_number|phone:EG',
        ];
    }
}
