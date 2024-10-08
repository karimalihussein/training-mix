<?php

declare(strict_types=1);

namespace App\Billing;

use Devinweb\LaravelHyperpay\Contracts\BillingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class HyperPayBilling implements BillingInterface
{
    protected array $latLng;

    public function __construct(protected Request $request)
    {
        $this->request = $request;

        $this->latLng = $this->getLatLng($request->ip());
    }

    /**
     * Get the billing data.
     */
    public function getBillingData(): array
    {
        return $this->GetAddressFromLatLng();
    }

    protected function GetAddressFromLatLng(): array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$this->latlng.'&key=AIzaSyAFHz-7hKCyzYx2kWfY-S_kSi6Hm8pZ8jk');

        $array = $this->getBillingFromGeocode($response->json());

        return $array;
    }

    protected function getLatLng($ip)
    {
        $response = Http::withHeaders(['Accept' => 'application/json'])->get('https://ipinfo.io/'.$ip);
        $response = $response->json();
        if (Arr::has($response, 'loc')) {
            return Arr::get($response, 'loc');
        }

        return '21.4901,39.1862';
    }

    protected function getBillingFromGeocode(array $response): array
    {
        $billing = [
            'billing.street1' => '',
            'billing.city' => '',
            'billing.state' => '',
            'billing.country' => '',
            'billing.postcode' => '',
        ];

        if (Arr::has($response, 'results')) {
            $result = $response['results'];

            $address_components = Arr::has($result[0], 'address_components') ? $result[0]['address_components'] : [];

            $billing['billing.street1'] = Arr::has($result[0], 'formatted_address') ? $result[0]['formatted_address'] : '';

            for ($i = 0; $i < count($address_components); $i++) {
                $child_address_components = $address_components[$i];
                switch (Arr::get($child_address_components, 'types')[0]) {
                    case 'locality':
                        $billing['billing.city'] = Arr::get($child_address_components, 'long_name');
                        break;
                    case 'administrative_area_level_1':
                        $billing['billing.state'] = Arr::get($child_address_components, 'long_name');
                        break;
                    case 'country':
                        $billing['billing.country'] = Arr::get($child_address_components, 'short_name');
                        break;
                        // case 'postal_code':
                        //     $billing['billing.postcode'] = Arr::get($child_address_components, 'long_name');
                        //     break;
                }
            }
        }

        return collect($billing)->filter()->all();
    }
}
