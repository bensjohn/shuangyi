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
        $this->attributes['spotimage'] = implode(',', $value);
    }

    public function getSpotimageAttribute($value)
    {
        return explode(',', $value);
    }

    public function setSpotfileAttribute($value)
    {
        $this->attributes['spotfile'] = implode(',', $value);
    }

    public function getSpotfileAttribute($value)
    {
        return explode(',', $value);
    }
}
