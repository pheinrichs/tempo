<?php

namespace App;

use App\Events\ContactModified;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['home_phone', 'mobile_phone', 'work_phone', 'name', 'email', 'primary', 'account_id'];

    protected $casts = [
        'primary' => 'boolean'
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id');
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ContactModified::class,
        'updated' => ContactModified::class,
        'created' => ContactModified::class,
    ];

}
