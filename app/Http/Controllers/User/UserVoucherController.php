<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Carbon\Carbon;

class UserVoucherController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $vouchers = Voucher::where('vc_status', Voucher::STATUS_ACTIVE)
            ->where(function ($query) use ($now) {
                $query->whereNull('vc_started_at')->orWhere('vc_started_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('vc_ended_at')->orWhere('vc_ended_at', '>=', $now);
            })
            ->orderByDesc('id')
            ->paginate(10);

        $title_page = 'Voucher của bạn';
        return view('user.voucher', compact('vouchers', 'title_page'));
    }
}
