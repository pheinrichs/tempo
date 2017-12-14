<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountTab extends Model
{
    protected $fillable = ['name', 'account_id'];


    public function account() {
        return $this->belongsTo('App\Account');
    }


    public function fields() {
        return $this->hasMany('App\TabField', 'tab_id');
    }
}
