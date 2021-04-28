<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarInsure extends Model
{
    public $table = 'sy_carinsure';
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
        return $this->belongsTo(CarData::class, 'carID', $this->getKeyName());
    }

    public function InsureData()
    {
        return $this->belongsTo(InsureData::class, 'insureID', $this->getKeyName());
    }
}
