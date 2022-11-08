<?php

namespace App\Services;

use Braintree\Gateway;

class Braintree
{

    public function createPlan()
    {
        $gateway = $this->initializeGateway();

    }

    public function generateClientToken($userId)
    {
        $gateway = $this->initializeGateway();

        return $gateway->clientToken()->generate([
            "customerId" => $userId
        ]);
    }

    private function initializeGateway(): Gateway
    {
        return new Gateway([
            'environment' => env('BRAIN_TREE_ENVIRONMENT'),
            'merchantId' => env('BRAIN_TREE_MERCHANT_ID'),
            'publicKey' => env('BRAIN_TREE_PUBLIC_KEY'),
            'privateKey' => env('BRAIN_TREE_PRIVATE_KEY'),
        ]);
    }
}
