<?php

declare(strict_types=1);

namespace App\Models\Validators;

use App\Models\Office;
use Illuminate\Validation\Rule;

class OfficeValidator
{
    public function validate(Office $office, array $attributes): array
    {
        return validator(
            $attributes,
            [
                'title' => [Rule::when($office->exists, 'sometimes'), 'required', 'string'],
                'description' => [Rule::when($office->exists, 'sometimes'), 'required', 'string'],
                'lat' => [Rule::when($office->exists, 'sometimes'), 'required', 'numeric'],
                'lng' => [Rule::when($office->exists, 'sometimes'), 'required', 'numeric'],
                'address_line1' => [Rule::when($office->exists, 'sometimes'), 'required', 'string'],
                'price_per_day' => [Rule::when($office->exists, 'sometimes'), 'required', 'integer', 'min:100'],
                'featured_image_id' => [Rule::exists('images', 'id')->where('resource_type', 'office')->where('resource_id', $office->id)],
                'address_line2' => ['string'],
                'hidden' => ['boolean'],
                'monthly_discount' => ['integer', 'min:0', 'max:90'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['integer', Rule::exists('tags', 'id')],
            ]
        )->validate();
    }
}
