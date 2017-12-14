<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabField extends Model
{
    protected $fillable = ['tab_id', 'name', 'value'];


    public function tab() {
        return $this->belongsTo('App\AccountTab','tab_id');
    }

    /**
     * Encypt Field value
     * @param STRING $value
     */
    public function setValueAttribute($value) {
        $this->attributes['value'] = encrypt($value);
    }

    /**
     * Decrpyt Field value
     * @param STRING $value
     */
    public function getValueAttribute($value) {
        return decrypt($value);
    }
}
