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
                <div class="title">THÔNG TIN GIỎ HÀNG</div>
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
                                        <a href="{{ route('get.product.detail', \Str::slug($item->name).'-'.$item->id) }}"
                                           title="{{ $item->name }}" class="avatar image contain">
                                            <img alt="" src="{{ pare_url_file($item->options->image) }}" class="lazyload">
                                        </a>
                                    </td>
                                    <td>
                                        <div class="name-product">
                                            <a href="{{ route('get.product.detail', \Str::slug($item->name).'-'.$item->id) }}">
                                                <strong>{{ $item->name }}</strong>
                                            </a>
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
                                            <input type="number"  min="1" class="input_quantity" disabled name="quantity_14692" value="{{  $item->qty }}" id="">
                                            <p data-price="{{ $item->price }}" data-url="{{  route('ajax_get.shopping.update', $key) }}" data-id-product="{{  $item->id }}">
                                                <span class="js-increase">+</span>
                                                <span class="js-reduction">-</span>
                                            </p>
                                            <a href="{{  route('get.shopping.delete', $key) }}" class="js-delete-item btn-action-delete"><i class="la la-trash"></i></a>
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
                </div>
            </div>
        </div>
        <div class="right">
            <div class="customer">
                <div class="title">MÃ GIẢM GIÁ</div>
                <div class="customer__content">
                    <form action="{{ route('post.shopping.voucher') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="voucher">Nhập mã voucher</label>
                            <input type="text" class="form-control" id="voucher" name="vc_code" placeholder="Nhập mã giảm giá" value="{{ $totals['voucher']->vc_code ?? '' }}">
                        </div>
                        <div class="btn-buy">
                            <button class="btn btn-purple" style="width: 100%;border-radius: 5px" type="submit">
                                Áp dụng
                            </button>
                        </div>
                        @if($totals['voucher'])
                            <p style="margin-top: 10px">Đang áp dụng: <b>{{ $totals['voucher']->vc_code }}</b> <a href="{{ route('get.shopping.voucher.remove') }}">(Bỏ mã)</a></p>
                        @endif
                    </form>
                </div>
            </div>
            <div class="customer" style="margin-top: 20px">
                <div class="title">TÓM TẮT</div>
                <div class="customer__content">
                    <p class="d-flex" style="justify-content: space-between">Tạm tính <span id="js-cart-subtotal">{{ number_format($totals['subtotal'],0,',','.') }} đ</span></p>
                    <p class="d-flex" style="justify-content: space-between">Giảm giá <span id="js-cart-discount">- {{ number_format($totals['discount'],0,',','.') }} đ</span></p>
                    <p class="d-flex" style="justify-content: space-between;font-weight: bold">Tổng tiền <span id="sub-total">{{ number_format($totals['total'],0,',','.') }} đ</span></p>
                    <div class="btn-buy" style="margin-top: 10px">
                        <a class="buy1 btn btn-pink" style="width: 100%;border-radius: 5px" href="{{ route('get.shopping.checkout') }}">
                            Tiếp tục thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script src="{{ asset('js/cart.js') }}" type="text/javascript"></script>
    <script>
        @php
            $voucherInfo = $totals['voucher'] ? [
                'type'  => $totals['voucher']->vc_type,
                'value' => $totals['voucher']->vc_value,
                'max'   => $totals['voucher']->vc_max_discount,
            ] : null;
        @endphp

        var voucherInfo = @json($voucherInfo);

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function recalcCartTotals() {
            var subtotal = 0;
            document.querySelectorAll('.js-total-item').forEach(function (item) {
                var value = parseInt(item.textContent.replace(/\D/g, '')) || 0;
                subtotal += value;
            });

            var discount = 0;
            if (voucherInfo) {
                if (voucherInfo.type === {{ \App\Models\Voucher::TYPE_PERCENT }}) {
                    discount = Math.floor(subtotal * (voucherInfo.value / 100));
                    if (voucherInfo.max) {
                        discount = Math.min(discount, voucherInfo.max);
                    }
                } else {
                    discount = voucherInfo.value;
                }
                discount = Math.min(discount, subtotal);
            }

            var total = Math.max(subtotal - discount, 0);
            var subtotalEl = document.getElementById('js-cart-subtotal');
            var discountEl = document.getElementById('js-cart-discount');
            var totalEl = document.getElementById('sub-total');

            if (subtotalEl) subtotalEl.innerText = formatNumber(subtotal) + ' đ';
            if (discountEl) discountEl.innerText = '- ' + formatNumber(discount) + ' đ';
            if (totalEl) totalEl.innerText = formatNumber(total) + ' đ';
        }

        document.addEventListener('click', function (event) {
            if (event.target.closest('.js-increase') || event.target.closest('.js-reduction') || event.target.closest('.js-delete-item')) {
                setTimeout(recalcCartTotals, 500);
            }
        });

        document.addEventListener('DOMContentLoaded', recalcCartTotals);
    </script>
@stop
