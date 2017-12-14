<?php

namespace App;

use App\Events\AccountModified;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'address', 'postal', 'city', 'country', 'notes'];


    public function tabs () {
        return $this->hasMany('App\AccountTab', 'account_id');
    }

    public function contacts () {
        return $this->hasMany('App\Contact');
    }

    public function primary() {
        return $this->contacts()->where('primary', true)->first();
    }

    public function fields() {
        return $this->hasManyThrough('App\TabField', 'App\AccountTab', 'account_id', 'tab_id');
    }


    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => AccountModified::class,
        'updated' => AccountModified::class,
        'created' => AccountModified::class,
        'deleted' => AccountModified::class
    ];
}
