<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for flutterwave payments
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;
use Illuminate\Support\Facades\Http;
use Log;

class FlutterwavePaymentRepository {

    /**
     * The fooo repository instance.
     */
    protected $fooo;

    /**
     * Inject dependecies
     */
    public function __construct() {

    }

    /** ----------------------------------------------------
     * [onetime payment]
     * Start the process for a single flutterwave payment
     * @param array $data information payload
     * @return string checkout url
     * ---------------------------------------------------*/
    public function onetimePayment($data = []) {

        Log::info("flutterwave onetime payment request initiated", ['process' => '[flutterwave-payment]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'payload' => $data]);

        //validate
        if (!is_array($data)) {
            Log::error("invalid paymment payload data", ['process' => '[flutterwave-payment]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'payload' => $data]);
            return false;
        }

        //create our own checkout session id
        $checkout_session_id = str_unique();

        // payment information
        $payload = [
            'tx_ref' => $checkout_session_id,
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'redirect_url' => $data['thank_you_url'],
            'customer' => [
                'email' => $data['email'],
                'name' => $data['payee_full_name'],
            ],
            'customizations' => [
                'title' => $data['item_name'],
            ],
            'meta' => [
                'invoice_id' => $data['invoice_id'],
                'checkout_session_id' => $checkout_session_id,
            ],
        ];

        Log::info("testing flutterwave payload", ['payload' => $payload]);

        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('system.settings2_flutterwave_secret_key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.flutterwave.com/v3/payments', $payload);

            //get response from flutterwave
            if ($response->successful()) {

                //response
                $response = $response->json();

                //was a payment url provided
                if (isset($response['data']['link'])) {
                    Log::info("flutterwave onetime payment initiated - success", ['process' => '[flutterwave-payment]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'response' => $response]);

                    //save session id in sessions database
                    $payment_session = new \App\Models\PaymentSession();
                    $payment_session->session_creatorid = $data['payee_id'];
                    $payment_session->session_creator_fullname = $data['payee_full_name'];
                    $payment_session->session_creator_email = $data['payee_email'];
                    $payment_session->session_gateway_name = 'flutterwave';
                    $payment_session->session_gateway_ref = $checkout_session_id;
                    $payment_session->session_amount = $data['amount'];
                    $payment_session->session_invoices = $data['invoice_id'];
                    $payment_session->save();

                    //return the checkout url
                    return $response['data']['link'];

                } else {
                    Log::error("flutterwave onetime payment initiated - failed", ['process' => '[flutterwave-payment]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'response' => $response]);
                    return false;
                }
            } else {
                $error = $response->json();
                $error_message = $error['message'];
                Log::error("flutterwave onetime payment initiated - failed - [error]: $error_message", ['process' => '[flutterwave-payment]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'payload' => $data]);
                return false;
            }
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            Log::error("flutterwave onetime payment initiated - failed - [error] $error_message ", ['process' => '[flutterwave-payment]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'payload' => $data]);
            return false;
        }

    }

}
