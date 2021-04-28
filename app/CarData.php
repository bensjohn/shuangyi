<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarData extends Model
{
    public $table = 'sy_cardata';
    use SoftDeletes;

    public function usercreate()
    {
        return $this->belongsTo(SyUser::class, 'create_by', $this->getKeyName());
    }

    public function userupdate()
    {
        return $this->belongsTo(SyUser::class, 'update_by', $this->getKeyName());
    }

    public function carClassData()
    {
        return $this->belongsTo(carClassData::class, 'carClassID', $this->getKeyName());
    }

    public function InsureData()
    {
        return $this->belongsTo(InsureData::class, 'insureID', $this->getKeyName());
    }

    public function setXszfileAttribute($value)
    {
        $this->attributes['xszfile'] = implode(',', $value);
    }

    public function getXszfileAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCarfileAttribute($value)
    {
        $this->attributes['carfile'] = implode(',', $value);
    }

    public function getCarfileAttribute($value)
    {
        return explode(',', $value);
    }
}
