<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpDataList extends Model
{

    public $table = 'sy_updatalist';
    use SoftDeletes;

    public function usercreate()
    {
        return $this->belongsTo(SyUser::class,'create_by');
    }

    public function userupdate()
    {
        return $this->belongsTo(SyUser::class,'update_by');
    }

}
