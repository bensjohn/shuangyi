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

    public function setInsureFileAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['insureFile'] = json_encode($pictures);
        }
    }

    public function getInsureFileAttribute($pictures)
    {
        return $pictures;
    }
}
