<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $guarded = [''];

    public function getTargetAttribute()
    {
        if($this->sd_target == 2) {
            return '_self';
        }
        if($this->sd_target == 3) {
            return '_parent';
        }
        if($this->sd_target == 4) {
            return '_top';
        }
        return '_blank';
    }
}
