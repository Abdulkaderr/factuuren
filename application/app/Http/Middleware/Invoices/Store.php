<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [create] precheck processes for invoices
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Invoices;
use Closure;

class Store {

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        /** -------------------------------------------------------------------------
         * New invoice is being created. Set the correct due date
         * -------------------------------------------------------------------------*/
        if (request('invoice_due_date_method') == 'set_due_date_manually') {
            request()->merge([
                'bill_due_date' => request('bill_due_date_manually'),
            ]);
        }

        return $next($request);
    }
}
