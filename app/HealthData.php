<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class HealthData extends Model
    {
        public $table = 'sy_healthdata';
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

        public function setMileagefileAttribute($value)
        {
            if (is_array($value)){
                $this->attributes['mileagefile'] = json_encode($value);
            }
        }

        public function getMileagefileAttribute($value)
        {
            return json_decode($value, true);
        }
    }
