<?php

namespace App\Http\Requests;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
            'domain' => 'required|string',
            'phone_number' => 'required|numeric|min:10',
        ];

    }

    public function prepareForValidation()
    {
        $this->merge([
            'domain' => $this->domain.'.'.config('tenancy.central_domains')[0],
        ]);
    }

    public function store(): Tenant
    {
        $tenant = Tenant::Create($this->only(['name', 'domain', 'email', 'company_code', 'password', 'phone_number']));
        $tenant->createDomain(['domain' => $this->domain]);

        return $tenant;
    }
}
