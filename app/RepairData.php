<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairData extends Model
{
    public $table = 'sy_repairdata';
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

    public function giveCarid_()
    {
        return $this->belongsTo(SyUser::class, 'giveCarID', $this->getKeyName());
    }

    public function repairClassData()
    {
        return $this->belongsTo(RepairClassData::class, 'repairID', $this->getKeyName());
    }

    public function setRepairimageAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['repairimage'] = json_encode($value);
        }
    }

    public function getRepairimageAttribute($value)
    {
        return json_decode($value,true);
    }

    public function setRepairfileAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['repairfile'] = json_encode($value);
        }
    }

    public function getRepairfileAttribute($value)
    {
        return json_decode($value,true);
    }
}
