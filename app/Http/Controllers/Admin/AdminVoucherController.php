<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestVoucher;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminVoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderByDesc('id')->paginate(10);
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(AdminRequestVoucher $request)
    {
        $data = $this->prepareData($request);
        Voucher::create($data);

        return redirect()->route('admin.voucher.index');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.update', compact('voucher'));
    }

    public function update(AdminRequestVoucher $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        $data = $this->prepareData($request);
        $voucher->update($data);

        return redirect()->back();
    }

    public function delete($id)
    {
        $voucher = Voucher::find($id);
        if ($voucher) {
            $voucher->delete();
        }
        return redirect()->back();
    }

    protected function prepareData(Request $request)
    {
        $data = $request->except(['_token']);
        $data['vc_started_at'] = $request->vc_started_at ? Carbon::parse($request->vc_started_at) : null;
        $data['vc_ended_at'] = $request->vc_ended_at ? Carbon::parse($request->vc_ended_at) : null;
        $data['vc_quantity'] = $request->vc_quantity ?? 0;
        return $data;
    }
}
