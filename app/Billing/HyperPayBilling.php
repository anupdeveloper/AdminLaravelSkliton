<?php

namespace App\Billing;

use Devinweb\LaravelHyperpay\Contracts\BillingInterface;

class HyperPayBilling implements BillingInterface
{
    /**
     * Get the billing data.
     *
     * @return array
     */
    public function getBillingData(): array
    {
        return [
            'billing.street1' => 'street 1',
            'billing.city' => 'riyadh',
            'billing.state' => 'riyadh',
            'billing.country' => 'SA',
            'billing.postcode' => '000000',
        ];
    }
}