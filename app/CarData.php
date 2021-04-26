<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function InsureClassData()
    {
        return $this->belongsTo(InsureClassData::class, 'insureID', $this->getKeyName());
    }
}
