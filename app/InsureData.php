<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsureData extends Model
{
    public $table = 'sy_insuredata';
    use SoftDeletes;

    public function usercreate()
    {
        return $this->belongsTo(SyUser::class, 'create_by', $this->getKeyName());
    }

    public function userupdate()
    {
        return $this->belongsTo(SyUser::class, 'update_by', $this->getKeyName());
    }

    public function InsureClassData()
    {
        return $this->belongsTo(InsureClassData::class, 'insureDataID', $this->getKeyName());
    }

    public function setInsureimageAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['insureimage'] = json_encode($value);
        }
    }

    public function getInsureimageAttribute($value)
    {
        return json_decode ($value,true);
    }

    public function setInsurefileAttribute($value)
    {
        if (is_array($value)){
            $this->attributes['insurefile'] = json_encode($value);
        }
    }

    public function getInsurefileAttribute($value)
    {
        return json_decode ($value,true);
    }
}
