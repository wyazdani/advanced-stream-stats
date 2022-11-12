<?php

namespace App\Http\Controllers;

use App\Services\Braintree;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $brainTree = new Braintree();
        $customerId = $brainTree->createCustomer();
        $paymentMethodToken = $brainTree->createPaymentMethod($customerId, $request->paymentMethodNonce);
        $brainTree->createSubscription($paymentMethodToken, $request->planId);

    }
}
