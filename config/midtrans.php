<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans payment gateway.
    | Get your credentials from: https://dashboard.midtrans.com
    |
    */

    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Sandbox URL: https://app.sandbox.midtrans.com/snap/snap.js
    // Production URL: https://app.midtrans.com/snap/snap.js
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
