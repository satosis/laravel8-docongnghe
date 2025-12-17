@extends('layouts.app_master_frontend')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.min.css') }}">
    <style type="text/css">
        @media (max-width: 767px) {
            .name-product {
                width: 300px;white-space: normal;
            }
        }

    </style>
@stop
@section('content')
    <div class="container cart">
        <div class="left">
            <div class="list">
                <div class="title">KIỂM TRA ĐƠN HÀNG</div>
                <div class="list__content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 100px;"></th>
                                <th style="width: 30%">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($shopping as $key => $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('get.product.detail',\Str::slug($item->name).'-'.$item->id) }}"
                                           title="{{ $item->name }}" class="avatar image contain">
                                            <img alt="" src="{{ pare_url_file($item->options->image) }}" class="lazyload">
                                        </a>
                                    </td>
                                    <td>
                                        <div style="" class="name-product">
                                            <a href="{{ route('get.product.detail',\Str::slug($item->name).'-'.$item->id) }}"><strong>{{ $item->name }}</strong></a>
                                            <p>Kích cỡ: {{ isset($item->options['size']) ? $size[$item->options['size']] : 'S' }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p><b>{{  number_format($item->price,0,',','.') }} đ</b></p>
                                        <p>
                                            @if ($item->options->price_old)
                                                <span style="text-decoration: line-through;">{{  number_format(number_price($item->options->price_old),0,',','.') }} đ</span>
                                                <span class="sale">- {{ $item->options->sale }} %</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <div class="qty_number">
                                            <input type="number" min="1" class="input_quantity" disabled value="{{  $item->qty }}">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="js-total-item">{{ number_format($item->price * $item->qty,0,',','.') }} đ</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Giỏ hàng trống</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 10px">
                        <p style="margin: 0">Tạm tính: <b>{{ number_format($totals['subtotal'],0,',','.') }} đ</b></p>
                        <p style="margin: 0">Giảm giá: <b>- {{ number_format($totals['discount'],0,',','.') }} đ</b></p>
                        <p style="margin: 0">Tổng thanh toán: <b id="sub-total">{{ number_format($totals['total'],0,',','.') }} đ</b></p>
                        @if($totals['voucher'])
                            <p style="margin: 0">Áp dụng voucher: <b>{{ $totals['voucher']->vc_code }}</b></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="customer">
                <div class="title">THÔNG TIN ĐẶT HÀNG</div>
                <div class="customer__content">
                    <form class="from_cart_register" action="{{ route('post.shopping.pay') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" >Họ và tên <span class="cRed">(*)</span></label>
                            <input name="tst_name" id="name" required="" value="{{ get_data_user('web','name') }}" type="text" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="phone">Điện thoại <span class="cRed">(*)</span></label>
                            <input name="tst_phone" id="phone" required="" value="{{ get_data_user('web','phone') }}" type="text" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ <span class="cRed">(*)</span></label>
                            <input name="tst_address" id="address" required="" value="{{ get_data_user('web','address') }}" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="cRed">(*)</span></label>
                            <input name="tst_email" id="email" required="" value="{{ get_data_user('web','email') }}" type="text" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="note">Ghi chú thêm</label>
                            <textarea name="tst_note" id="note" cols="3" style="min-height: 100px;" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="btn-buy">
                            <button class="buy1 btn btn-purple {{ \Auth::id() ? '' : 'js-show-login' }}" style="width: 100%;border-radius: 5px" type="submit" name="tst_type" value="1">
                                Thanh toán khi nhận hàng ({{ number_format($totals['total'],0,',','.') }} đ)
                            </button>
                        </div>
                        <div class="btn-buy" style="margin-top: 10px">
                            <button class="buy1 btn btn-pink {{ \Auth::id() ? '' : 'js-show-login' }}" style="width: 100%;border-radius: 5px" type="submit" name="tst_type" value="2">
                                Thanh toán trực tuyến (VNPAY)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script src="{{ asset('js/cart.js') }}" type="text/javascript"></script>
@stop
