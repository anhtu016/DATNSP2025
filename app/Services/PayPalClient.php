<?php 
namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
        return new SandboxEnvironment(
            config('paypal.client_id'),
            config('paypal.client_secret')
        );
    }
}
