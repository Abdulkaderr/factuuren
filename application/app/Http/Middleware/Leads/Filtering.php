<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles filter processing for leads
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Leads;

use Closure;

class Filtering {

    /**
     * This middleware handles filter saving, applying, and clearing
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //handle clear filter request
        if (request()->filled('clear-filter') && request('clear-filter') == 'yes') {
            $this->clearFilter();
            return redirect('/leads');
        }

        //filter handling
        if (request()->routeIs('leads.search')) {
            if (request('query-type') == 'filter') {
                $this->saveFilter();
            } else {
                $this->applyFilter();
            }
        } else {
            $this->applyFilter();
        }

        return $next($request);
    }

    /**
     * Save filter data when user submits filter panel
     * @return null
     */
    private function saveFilter() {

        //get or create filter record for current user
        if (!$filter = \App\Models\Filter::where('filter_userid', auth()->id())
            ->where('filter_type', 'leads')->first()) {
            $filter = new \App\Models\Filter();
            $filter->filter_userid = auth()->id();
            $filter->filter_type = 'leads';
            $filter->filter_created = now();
        }

        //check if remember filter checkbox is enabled
        if (request()->filled('filter_remember')) {
            //get all GET parameters
            $payload = request()->all();

            //exclude system parameters that shouldn't be saved
            $exclude = ['query-type', 'action', 'source', 'filter_remember'];
            $payload = array_diff_key($payload, array_flip($exclude));

            //save payload (mutator handles JSON encoding)
            $filter->filter_payload = $payload;
            $filter->filter_filter_applied = 'yes';
            $filter->filter_remember = 'yes';
            $filter->filter_updated = now();
            $filter->save();

            //set config for active filter
            config(['filter.status' => 'active']);
            config(['filter.saved_data' => $payload]);

        } else {
            //clear filter data
            $filter->filter_payload = null;
            $filter->filter_filter_applied = 'no';
            $filter->filter_remember = 'no';
            $filter->filter_updated = now();
            $filter->save();

            //set config for no active filter
            config(['filter.status' => '']);
            config(['filter.saved_data' => []]);
        }
    }

    /**
     * Apply saved filter data to current request
     * @return null
     */
    private function applyFilter() {

        //get filter record for current user
        if ($filter = \App\Models\Filter::where('filter_userid', auth()->id())
            ->where('filter_type', 'leads')
            ->where('filter_filter_applied', 'yes')
            ->first()) {

            //get payload (accessor handles JSON decoding)
            $payload = $filter->filter_payload;

            if (is_array($payload) && count($payload) > 0) {
                //prepare data for request merge - extract IDs from array values
                $request_data = [];
                foreach ($payload as $key => $value) {
                    //if value is an array with 'id' and 'text', extract just the ID for request
                    if (is_array($value) && isset($value['id']) && isset($value['text'])) {
                        $request_data[$key] = $value['id'];
                    } else {
                        $request_data[$key] = $value;
                    }
                }

                //merge into current request
                request()->merge($request_data);

                //set config for active filter (keep full payload with arrays)
                config(['filter.status' => 'active']);
                config(['filter.saved_data' => $payload]);

                return;
            }
        }

        //no active filter
        config(['filter.status' => '']);
        config(['filter.saved_data' => []]);
    }

    /**
     * Clear saved filter data
     * @return null
     */
    private function clearFilter() {

        //get filter record for current user
        if ($filter = \App\Models\Filter::where('filter_userid', auth()->id())
            ->where('filter_type', 'leads')->first()) {

            $filter->filter_payload = null;
            $filter->filter_filter_applied = 'no';
            $filter->filter_remember = 'no';
            $filter->save();
        }

        //set config for no active filter
        config(['filter.status' => '']);
    }
}
