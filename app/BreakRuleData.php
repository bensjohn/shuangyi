<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BreakRuleData extends Model
{
    public $table = 'sy_breakruledata';
    use SoftDeletes;

    public function usercreate()
    {
        return $this->belongsTo(SyUser::class, 'create_by', $this->getKeyName());
    }

    public function userupdate()
    {
        return $this->belongsTo(SyUser::class, 'update_by', $this->getKeyName());
    }

    public function carData()
    {
        return $this->belongsTo(CarData::class, 'carID', $this->getKeyName());
    }

    public function userid_()
    {
        return $this->belongsTo(SyUser::class, 'userID', $this->getKeyName());
    }

    public function dealid_()
    {
        return $this->belongsTo(SyUser::class, 'dealID', $this->getKeyName());
    }

    public function setBreakrulecontentAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['breakrulecontent'] = json_encode($value);
        }
    }

    public function getBreakrulecontentAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setBreakpictureAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['breakrulecontent'] = json_encode($value);
        }
    }

    public function getBreakpictureAttribute($value)
    {
        return json_decode($value, true);
    }
}
