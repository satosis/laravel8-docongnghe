@extends('layouts.app_master_frontend')
@section('css')
    @php
        $display_menu = config('layouts.component.cate.home.display');
    @endphp
    <style>
		<?php $style = file_get_contents('css/home_insights.min.css');echo $style;?>
    </style>
@stop
@section('content')
    <div class="container tech-hero">
        <div>
            <div class="tech-hero__eyebrow">Thiết bị công nghệ chính hãng</div>
            <div class="tech-hero__title">Nâng tầm trải nghiệm số của bạn</div>
            <p class="tech-hero__desc">Chọn laptop, PC, gaming gear và phụ kiện công nghệ với ưu đãi độc quyền, giao nhanh tận nơi và bảo hành rõ ràng.</p>
            <div class="tech-hero__actions">
                <a href="{{ route('get.product.list') }}" class="tech-btn-primary">
                    <i class="fa fa-shopping-bag"></i> Mua ngay
                </a>
                <a href="#flash_sale" class="tech-btn-ghost">
                    <i class="fa fa-bolt"></i> Xem ưu đãi công nghệ
                </a>
            </div>
            <ul class="tech-hero__badges">
                <li class="tech-hero__badge"><i class="fa fa-shield"></i><span>Hàng chính hãng, bảo hành minh bạch</span></li>
                <li class="tech-hero__badge"><i class="fa fa-truck"></i><span>Giao nhanh trong 2 giờ</span></li>
                <li class="tech-hero__badge"><i class="fa fa-headphones"></i><span>Hỗ trợ kỹ thuật 24/7</span></li>
            </ul>
        </div>
        <div class="tech-hero__visual">
            <div class="tech-hero__glass">
                <img src="{{ asset('uploads/banner-3.png') }}" alt="Ưu đãi công nghệ" />
            </div>
        </div>
    </div>
    <div class="container tech-surface" id="before-slide">
        <div class="tech-highlight-grid">
            <div class="tech-highlight-card"><i class="fa fa-laptop"></i><span>PC - Laptop cấu hình cao</span></div>
            <div class="tech-highlight-card"><i class="fa fa-gamepad"></i><span>Gaming gear chính hãng</span></div>
            <div class="tech-highlight-card"><i class="fa fa-headphones"></i><span>Âm thanh - phụ kiện chất</span></div>
            <div class="tech-highlight-card"><i class="fa fa-refresh"></i><span>Đổi trả trong 15 ngày</span></div>
        </div>
        <div class="product-one">
            <div class="top tech-section-heading">
                <a href="#" title="" class="main-title main-title-2">Sản phẩm bán chạy</a>
                <small>Top lựa chọn cho game thủ, designer, coder</small>
            </div>
            <div class="bot">
                <div class="left">
                    <div class="image">
                        <a href="javascript:;" title="" class=" image" target="_blank">
                            <img style="height: 310px;" class="lazyload lazy" alt="" src="{{  asset('images/preloader.gif') }}"  data-src="{{  asset('uploads/banner-1.png') }}" />
                        </a>
                    </div>
                </div>
                <div class="right js-product-one owl-carousel owl-theme owl-custom">
                    @foreach($productsPay as $product)
                        <div class="item">
                            @include('frontend.components.product_item',[ 'product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="flash_sale">
            <a href="" title="" class="image" target="_blank">
                <img  alt="" src="uploads/banner-3.png" class="lazyload" style="width:49%;height:250px;object-fit: cover;" />
                <img  alt="" src="uploads/banner-2.png" class="lazyload" style="width:49%;height:250px;object-fit: cover;" />
            </a>

        </div>
        @if ($event2)
            @include('frontend.pages.home.include._inc_flash_sale')
        @endif

        <div class="product-three">
            <div class="top tech-section-heading">
                <a href="#" title="" class="main-title main-title-2">Sản phẩm mới</a>
                <small>Thiết kế hiện đại, cấu hình tối ưu</small>
            </div>
            <div class="bot">
                <div class="left">
                    <div class="image">
                        <a href="javascript:;" title="" class="" target="_blank">
                            <img style="height: 310px;" class="lazyload lazy" alt="event3" src="{{  asset('images/preloader.gif') }}"  data-src="{{  asset('uploads/banner-2.png') }}" />
                        </a>
                    </div>
                </div>
                <div class="right js-product-one owl-carousel owl-theme owl-custom">
                    @if (isset($productsNew))
                        @foreach($productsNew as $product)
                            <div class="item">
                                @include('frontend.components.product_item',['product' => $product])
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        @if (!detectDevice()->isMobile())
            <div class="container">
                <div class="banner" style="display: flex">
                    <div class="item" style="width: 50%;">
                        <a href="">
                            <img src="{{ asset('uploads/banner-1.png') }}" style="height:250px;width:100%">
                        </a>
                    </div>
                    <div class="item" style="width: 50%;">
                        <a href="">
                            <img src="{{ asset('uploads/banner-2.png') }}" style="height:250px;width:100%">
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <div class="product-two">
            <div class="top tech-section-heading">
                <a href="#" class="main-title main-title-2">Sản phẩm nổi bật</a>
                <small>Được săn đón nhiều nhất tuần này</small>
            </div>
            <div class="bot">
                @if (isset($productsHot))
                    @foreach($productsHot as $product)
                    {{-- {{ dd($product) }} --}}
                        <div class="item">
                            @include('frontend.components.product_item',['product' => $product])
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="product-two" id="product-recently"></div>
        <div id="product-by-category"></div>
        @include('frontend.pages.home.include._inc_article')
    </div>
@stop

@section('script')
    <script>
		var routeRenderProductRecently  = '{{ route('ajax_get.product_recently') }}';
		var routeRenderProductByCategory  = '{{ route('ajax_get.product_by_category') }}';
		var CSS = "{{ asset('css/home.min.css') }}";
    </script>
    <script type="text/javascript">
		<?php $js = file_get_contents('js/home.js');echo $js;?>
    </script>
@stop
