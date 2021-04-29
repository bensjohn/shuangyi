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
        $this->attributes['breakrulecontent'] = implode(',', $value);
    }

    public function getBreakrulecontentAttribute($value)
    {
        return explode(',', $value);
    }

    public function setBreakpictureAttribute($value)
    {
        $this->attributes['breakpicture'] = implode(',', $value);
    }

    public function getBreakpictureAttribute($value)
    {
        return explode(',', $value);
    }
}
