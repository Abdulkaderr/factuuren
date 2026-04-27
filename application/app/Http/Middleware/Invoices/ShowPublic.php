<?php

namespace App\Http\Middleware\Invoices;

use Closure;
use Log;

class ShowPublic {

    public function handle($request, Closure $next) {

        $bill_uniqueid = $request->route('invoice');

        //frontend
        $this->fronteEnd();

        if (!$invoice = \App\Models\Invoice::Where('bill_uniqueid', $bill_uniqueid)->first()) {
            Log::error("invoice could not be found", ['process' => '[invoicesMiddlewareShowPublic]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'invoice_id' => $bill_uniqueid ?? '']);
            abort(404);
        }

        return $next($request);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        //stripe js
        if (config('system.settings_stripe_status') == 'enabled') {
            config([
                'visibility.stripe_js' => true,
            ]);
        }

        //razorpay js
        if (config('system.settings_razorpay_status') == 'enabled') {
            config([
                'visibility.razorpay_js' => true,
            ]);
        }

        //tap payments js
        if (config('system.settings2_tap_status') == 'enabled') {
            config([
                'visibility.tap_gateway_js' => true,
            ]);
        }

    }
}