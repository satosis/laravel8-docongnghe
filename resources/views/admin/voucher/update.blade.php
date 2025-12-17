@extends('layouts.app_master_admin')
@section('content')
    <section class="content-header">
        <h1>Cập nhật voucher</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cập nhật voucher</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên voucher</label>
                                <input type="text" class="form-control" id="name" name="vc_name" value="{{ old('vc_name', $voucher->vc_name) }}" placeholder="Giảm giá ...">
                                @if($errors->first('vc_name'))
                                    <span class="text-danger">{{ $errors->first('vc_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="code">Mã voucher</label>
                                <input type="text" class="form-control" id="code" name="vc_code" value="{{ old('vc_code', $voucher->vc_code) }}" placeholder="SALE2024">
                                @if($errors->first('vc_code'))
                                    <span class="text-danger">{{ $errors->first('vc_code') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" name="vc_description" id="description" rows="3" placeholder="Nội dung khuyến mãi">{{ old('vc_description', $voucher->vc_description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Loại giảm</label>
                                <select name="vc_type" class="form-control">
                                    <option value="1" {{ old('vc_type', $voucher->vc_type) == 1 ? 'selected' : '' }}>Giảm theo %</option>
                                    <option value="2" {{ old('vc_type', $voucher->vc_type) == 2 ? 'selected' : '' }}>Giảm tiền</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Giá trị</label>
                                <input type="number" min="1" class="form-control" name="vc_value" value="{{ old('vc_value', $voucher->vc_value) }}">
                                @if($errors->first('vc_value'))
                                    <span class="text-danger">{{ $errors->first('vc_value') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Giảm tối đa (để trống nếu không giới hạn)</label>
                                <input type="number" min="1" class="form-control" name="vc_max_discount" value="{{ old('vc_max_discount', $voucher->vc_max_discount) }}">
                            </div>
                            <div class="form-group">
                                <label>Số lượng áp dụng (0 = không giới hạn)</label>
                                <input type="number" min="0" class="form-control" name="vc_quantity" value="{{ old('vc_quantity', $voucher->vc_quantity) }}">
                            </div>
                            <div class="form-group">
                                <label>Ngày bắt đầu</label>
                                <input type="date" class="form-control" name="vc_started_at" value="{{ old('vc_started_at', $voucher->vc_started_at ? \Carbon\Carbon::parse($voucher->vc_started_at)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="form-group">
                                <label>Ngày kết thúc</label>
                                <input type="date" class="form-control" name="vc_ended_at" value="{{ old('vc_ended_at', $voucher->vc_ended_at ? \Carbon\Carbon::parse($voucher->vc_ended_at)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="vc_status" class="form-control">
                                    <option value="1" {{ old('vc_status', $voucher->vc_status) == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ old('vc_status', $voucher->vc_status) == 0 ? 'selected' : '' }}>Tạm dừng</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
