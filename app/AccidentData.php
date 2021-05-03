<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccidentData extends Model
{
    public $table = 'sy_accidentdata';
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

    public function accidentManagerid_()
    {
        return $this->belongsTo(SyUser::class, 'accidentManagerID', $this->getKeyName());
    }

    public function repairData()
    {
        return $this->belongsTo(RepairData::class, 'repairID', $this->getKeyName());
    }

    public function insureData()
    {
        return $this->belongsTo(InsureData::class, 'insureID', $this->getKeyName());
    }

    public function setSpotimageAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['spotimage'] = json_encode($value);
        }
    }

    public function getSpotimageAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setSpotfileAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['spotfile'] = json_encode($value);
        }
    }

    public function getSpotfileAttribute($value)
    {
        return json_decode($value, true);
    }
}
