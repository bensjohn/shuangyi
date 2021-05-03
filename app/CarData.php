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

    public function InsureDatas()
    {
        return $this->belongsToMany(InsureData::class, 'sy_carinsure', 'carID','insureID');
    }

    public function setXszfileAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['xszfile'] = json_encode($value);
        }
    }

    public function getXszfileAttribute($value)
    {
        return json_decode( $value,true);
    }

    public function setCarfileAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['carfile'] = json_encode($value);
        }
    }

    public function getCarfileAttribute($value)
    {
        return json_decode( $value,true);
    }
}
