@extends('layouts.app_master_user')
@section('content')
    <h2 class="title-user">Danh sách voucher đang diễn ra</h2>
    <div class="box">
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 70px">ID</th>
                    <th>Tên</th>
                    <th>Mã</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Thời gian</th>
                    <th>Giới hạn</th>
                </tr>
                </thead>
                <tbody>
                @forelse($vouchers as $voucher)
                    @php $type = \App\Models\Voucher::getType($voucher->vc_type); @endphp
                    <tr>
                        <td>{{ $voucher->id }}</td>
                        <td>{{ $voucher->vc_name }}</td>
                        <td><b>{{ $voucher->vc_code }}</b></td>
                        <td>{{ $type['name'] ?? 'N/A' }}</td>
                        <td>
                            {{ number_format($voucher->vc_value,0,',','.') }} {{ $type['suffix'] ?? '' }}
                            @if($voucher->vc_max_discount)
                                <p class="note">Tối đa {{ number_format($voucher->vc_max_discount,0,',','.') }} đ</p>
                            @endif
                        </td>
                        <td>
                            <p class="note">Bắt đầu: {{ $voucher->vc_started_at ? \Carbon\Carbon::parse($voucher->vc_started_at)->format('d/m/Y') : 'Ngay lập tức' }}</p>
                            <p class="note">Kết thúc: {{ $voucher->vc_ended_at ? \Carbon\Carbon::parse($voucher->vc_ended_at)->format('d/m/Y') : 'Không giới hạn' }}</p>
                        </td>
                        <td>{{ $voucher->vc_quantity ?: 'Không giới hạn' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Hiện tại chưa có voucher khả dụng</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="box-footer">
                {!! $vouchers->links() !!}
            </div>
        </div>
    </div>
@stop
