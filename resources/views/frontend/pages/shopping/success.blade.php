@extends('layouts.app_master_frontend')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.min.css') }}">
    <style>
        .payment-success {
            padding: 80px 0;
            min-height: 75vh;
            background: linear-gradient(135deg, #f3f7ff 0%, #ffffff 100%);
            display: flex;
            align-items: center;
        }

        .payment-success .card-success {
            max-width: 560px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 45px rgba(12, 58, 119, 0.08);
            padding: 40px 32px;
            text-align: center;
        }

        .payment-success .status-icon {
            width: 88px;
            height: 88px;
            margin: 0 auto 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            color: #fff;
        }

        .payment-success .status-icon.success {
            background: linear-gradient(135deg, #2ecc71, #1abc9c);
        }

        .payment-success .status-icon.failed {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .payment-success h1 {
            color: #243b53;
            margin-bottom: 12px;
            font-size: 28px;
            font-weight: 700;
        }

        .payment-success p {
            margin: 6px 0;
            color: #4b5563;
        }

        .payment-success .order-code {
            font-weight: 600;
            color: #0f7ae5;
        }

        .payment-success .cta {
            margin-top: 26px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .payment-success .btn-outline {
            background: #fff;
            color: #0f7ae5;
            border: 1px solid #0f7ae5;
        }

        .payment-success .btn-primary {
            background: #0f7ae5;
            color: #fff;
            border: 1px solid #0f7ae5;
        }

        .payment-success .btn-outline,
        .payment-success .btn-primary {
            min-width: 170px;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .payment-success .btn-outline:hover,
        .payment-success .btn-primary:hover {
            opacity: 0.9;
            text-decoration: none;
            transform: translateY(-1px);
        }
    </style>
@stop
@section('content')
    <div class="payment-success">
        <div class="container">
            <div class="card-success">
                <div class="status-icon {{ $status ? 'success' : 'failed' }}">
                    <span class="fa {{ $status ? 'fa-check' : 'fa-times' }}"></span>
                </div>
                <h1>{{ $status ? 'Thanh toán thành công' : 'Thanh toán thất bại' }}</h1>
                @if($transaction)
                    <p class="order-code">Mã đơn hàng: #{{ $transaction->id }}</p>
                @endif
                <p>{{ $status ? 'Cảm ơn bạn đã tin tưởng và đặt hàng tại cửa hàng của chúng tôi.' : 'Đã xảy ra lỗi khi thanh toán. Vui lòng thử lại hoặc chọn phương thức khác.' }}</p>
                <p>Bạn sẽ được chuyển về trang chủ sau vài giây.</p>

                <div class="cta">
                    <a class="btn btn-primary" href="{{ route('get.home') }}">Về trang chủ</a>
                    <a class="btn btn-outline" href="{{ route('get.track.transaction') }}" style='color:#0f7ae5 !important'>Xem tình trạng đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        setTimeout(function () {
            @if($status)
                window.location.href = '{{ route('get.home') }}';
            @else
                window.location.href = '{{ route('get.shopping.list') }}';
            @endif
        }, 3000);
    </script>
@stop
