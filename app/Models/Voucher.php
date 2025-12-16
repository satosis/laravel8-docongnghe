<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Voucher extends Model
{
    protected $guarded = [''];

    const TYPE_PERCENT = 1;
    const TYPE_CASH = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static $type = [
        self::TYPE_PERCENT => [
            'name' => 'Giảm theo %',
            'suffix' => '%'
        ],
        self::TYPE_CASH => [
            'name' => 'Giảm tiền',
            'suffix' => 'đ'
        ],
    ];

    public static function getType($type)
    {
        return Arr::get(self::$type, $type, []);
    }

    public function isActive()
    {
        if ($this->vc_status != self::STATUS_ACTIVE) {
            return false;
        }

        $now = Carbon::now();
        if ($this->vc_started_at && $now->lt(Carbon::parse($this->vc_started_at))) {
            return false;
        }

        if ($this->vc_ended_at && $now->gt(Carbon::parse($this->vc_ended_at))) {
            return false;
        }

        if ($this->vc_quantity > 0 && $this->vc_used >= $this->vc_quantity) {
            return false;
        }

        return true;
    }
}
