<?php

/** --------------------------------------------------------------------------------
 * This controller receives and processes webhook calls from Flutterwave
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\API\Flutterwave;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Webhooks extends Controller {

    public function __construct() {

        //parent
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * Receive and process flutterwave webhook
     * @return null
     */
    public function index() {

        //get the payload data
        $payload = json_decode(request()->getContent());

        Log::info("flutterwave webhook received - starting to process'", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'payload' => $payload]);

        // Verify webhook signature
        if (!$this->verifyWebhook()) {
            return response('Invalid Flutterwave signature', 400);
        }

        // Route to the correct method based on event name
        switch ($payload->event) {
        case 'charge.completed':
            $this->onetimePayment($payload->data);
            return;
        default:
            Log::info("flutterwave webhook [$payload->event] is not on the expected list - will now exit'", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return response('No expected webhook was found', 200);
        }

    }

    /**
     * process onetime payment
     *
     * @return null
     */
    public function onetimePayment($payload = []) {

        Log::info("flutterwave webhook is for a onetime payment'", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'payload' => $payload]);

        //get the data from the payload
        try {
            $transaction_id = $payload->id;
            $amount = $payload->amount;
            $currency = $payload->currency;
            $checkout_session_id = $payload->tx_ref;
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            Log::error("flutterwave webhook could not be processed. [error] $error_message", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //make sure we do not already recorded this payment
        if (\App\Models\Payment::Where('payment_transaction_id', $transaction_id)->exists()) {
            Log::info("flutterwave webhook - this transaction ($transaction_id) has already been recorded", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //make sure we do not already have this queued for processing
        if (\App\Models\Webhook::Where('webhooks_payment_transactionid', $transaction_id)->exists()) {
            Log::info("flutterwave webhook - this transaction ($transaction_id) is already queued for processing", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //record the webhook for processing later
        $webhook = new \App\Models\Webhook();
        $webhook->webhooks_gateway_name = 'flutterwave';
        $webhook->webhooks_type = 'payment_completed';
        $webhook->webhooks_payment_type = 'onetime';
        $webhook->webhooks_payment_amount = $amount;
        $webhook->webhooks_payment_transactionid = $transaction_id;
        $webhook->webhooks_matching_reference = $checkout_session_id;
        $webhook->webhooks_payload = json_encode($payload);
        $webhook->webhooks_status = 'new';
        $webhook->save();

    }

    /**
     * Verify Flutterwave webhook signature
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function verifyWebhook() {

        $signature = request()->header('verif-hash');
        $secret_hash = config('system.settings2_flutterwave_webhook_hash');

        Log::info("flutterwave webhook verification attempt", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'received_signature' => $signature, 'expected_secret_hash' => $secret_hash, 'signature_length' => strlen($signature ?? ''), 'secret_hash_length' => strlen($secret_hash ?? ''), 'signature_is_null' => is_null($signature), 'secret_hash_is_null' => is_null($secret_hash)]);

        if ($signature === $secret_hash) {
            Log::info("flutterwave webhook verification - success", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return true;
        }

        Log::error("flutterwave webhook verification - failed", ['process' => '[flutterwave-webhooks]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'reason' => 'signature mismatch']);

        return false;

    }

}
