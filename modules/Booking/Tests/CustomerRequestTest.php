<?php

namespace Modules\Booking\Tests;

use Modules\Booking\Http\Requests\CustomerRequest;
use Tests\TestCase;

final class CustomerRequestTest extends TestCase
{
    public function test_it_should_pass_with_valid_data(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'phone_number' => '+201069696963',
        ];

        $request = new CustomerRequest();

        $validator = validator($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_it_should_fail_with_invalid_data(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'phone_number' => '9668488433',
        ];

        $request = new CustomerRequest();

        $validator = validator($data, $request->rules());

        $this->assertFalse($validator->passes());
    }
}
