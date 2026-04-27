<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filters';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'filter_id';

    /**
     * Disable Laravel's automatic timestamp management
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filter_userid',
        'filter_type',
        'filter_remember',
        'filter_payload',
        'filter_filter_applied',
        'filter_created',
        'filter_updated',
    ];

    /**
     * Relationship to User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\User', 'filter_userid', 'id')->withDefault();
    }

    /**
     * Accessor: Automatically decode JSON when retrieving filter_payload
     *
     * @param  string  $value
     * @return array
     */
    public function getFilterPayloadAttribute($value) {
        if (is_null($value) || $value === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Mutator: Automatically encode to JSON when setting filter_payload
     *
     * @param  mixed  $value
     * @return void
     */
    public function setFilterPayloadAttribute($value) {
        if (is_null($value)) {
            $this->attributes['filter_payload'] = null;
        } elseif (is_array($value)) {
            $this->attributes['filter_payload'] = json_encode($value);
        } else {
            $this->attributes['filter_payload'] = $value;
        }
    }
}
