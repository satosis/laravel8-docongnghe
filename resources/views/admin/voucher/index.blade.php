@extends('layouts.app_master_admin')
@section('content')
    <section class="content-header">
        <h1>Quản lý voucher</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Voucher</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Tên</th>
                        <th>Mã</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                        <th>Thời gian</th>
                        <th>Đã dùng / Giới hạn</th>
                        <th>Trạng thái</th>
                        <th style="width: 150px">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vouchers as $voucher)
                        @php $type = \App\Models\Voucher::getType($voucher->vc_type); @endphp
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td>{{ $voucher->vc_name }}</td>
                            <td><b>{{ $voucher->vc_code }}</b></td>
                            <td>{{ $type['name'] ?? 'N/A' }}</td>
                            <td>
                                {{ number_format($voucher->vc_value,0,',','.') }} {{ $type['suffix'] ?? '' }}
                                @if($voucher->vc_max_discount)
                                    <p style="margin: 0;font-size: 12px">Tối đa {{ number_format($voucher->vc_max_discount,0,',','.') }} đ</p>
                                @endif
                            </td>
                            <td>
                                <p style="margin: 0">{{ $voucher->vc_started_at ? $voucher->vc_started_at : 'Bất kỳ' }}</p>
                                <p style="margin: 0">{{ $voucher->vc_ended_at ? $voucher->vc_ended_at : 'Không giới hạn' }}</p>
                            </td>
                            <td>{{ $voucher->vc_used }} / {{ $voucher->vc_quantity ?: '∞' }}</td>
                            <td>
                                <span class="label label-{{ $voucher->vc_status ? 'success' : 'default' }}">{{ $voucher->vc_status ? 'Kích hoạt' : 'Tạm dừng' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.voucher.update', $voucher->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Cập nhật</a>
                                <a href="{{ route('admin.voucher.delete', $voucher->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá?')"><i class="fa fa-trash"></i> Xoá</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="box-footer">
                    {!! $vouchers->links() !!}
                </div>
            </div>
        </div>
    </section>
@stop
