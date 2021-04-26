<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsureData extends Model
{
    public $table = 'sy_insureClassData';
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
}
