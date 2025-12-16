@extends('layouts.app_master_frontend')
@section('css')
    <style>
        .payment-success {
            padding: 60px 0;
            text-align: center;
        }
        .payment-success h1 {
            color: #27ae60;
            margin-bottom: 20px;
        }
        .payment-success p { margin: 0; }
    </style>
@stop
@section('content')
    <div class="container payment-success">
        <h1>{{ $status ? 'Thanh toán thành công' : 'Thanh toán thất bại' }}</h1>
        @if($transaction)
            <p>Mã đơn hàng: <b>#{{ $transaction->id }}</b></p>
        @endif
        <p>Bạn sẽ được chuyển về trang chủ sau vài giây.</p>
    </div>
@stop
@section('script')
    <script>
        setTimeout(function () {
            window.location.href = '{{ route('get.home') }}';
        }, 3000);
    </script>
@stop
