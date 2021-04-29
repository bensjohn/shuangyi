<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HireData extends Model
{
    public $table = 'sy_hiredata';
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

    public function insureid_()
    {
        return $this->belongsTo(InsureData::class, 'insureID', $this->getKeyName());
    }

    public function agentid_()
    {
        return $this->belongsTo(SyUser::class, 'agentID', $this->getKeyName());
    }


}
