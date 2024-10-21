@extends('shop_layout')
@section('title', 'shop')
@section('header')
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>

        <div>
            <ul id="navbar">
                <li><a href="{{ route('home') }}">หน้าหลัก</a></li>
                <li><a class="active link" href="{{ route('products.shop') }}">ซื้อพระ</a></li>
                <li><a href="{{ route('products.auction') }}">ประมูลพระ</a></li>
                @guest
                    <li><a href="{{ route('auth.register') }}">สมัครสมาชิก</a></li>
                    <li><a href="{{ route('auth.login') }}">เข้าสู่ระบบ</a></li>
                @else
                    <li><a class="cart_profile" href="{{ route('cart.show') }}"><img src="{{asset('Component Pic/Cart.png')}}" width="30"
                                height="30"></a></li>
                    <li><a class="cart_profile" href="{{ route('profile.edit') }}"><img
                                src="{{ asset(Auth::user()->profile_img ?? 'Profile Pic/default.png') }}" width="30"
                                height="30" style="border-radius: 50%; object-fit: cover;"></a></li>
                    <!-- Logout Form -->
                    {{-- <form action="{{ route('logout') }}" method="POST" class="hide-on-small-screen">
                        @csrf
                        <button type="submit">Logout</button>
                    </form> --}}
                @endguest
                <button id="navbarButton"><i class="fa fa-bars"></i></button>
            </ul>
        </div>
        <div id="navbar2">
            <div class="close_menu">
                <button id="closeMenuButton"><i class="fa fa-times"></i></button>
            </div>
            @auth
                <div class="profile_mobile">
                    <a class="cart_profile" href="{{ route('profile.edit') }}"><img
                            src="{{ asset(Auth::user()->profile_img ?? 'Profile Pic/default.png') }}" width="80"
                            height="80" style="border-radius: 50%; object-fit: cover;"></a>
                </div>
            @endauth
            <div class="box_menu">
                <a href="{{ route('home') }}"><button>หน้าหลัก</button></a>
            </div>
            <div class="box_menu">
                <a href="{{ route('products.shop') }}"><button class="active_menu">ซื้อพระ</button></a>
            </div>
            <div class="box_menu">
                <a href="{{ route('products.auction') }}"><button>ประมูลพระ</button></a>
            </div>
            @guest
                <div class="box_menu">
                    <a href="{{ route('auth.register') }}"><button>สมัครสมาชิก</button></a>
                </div>
                <div class="box_menu">
                    <a href="{{ route('auth.login') }}"><button>เข้าสู่ระบบ</button></a>
                </div>
            @else
                <div class="box_menu">
                    <a href="{{ route('cart.show') }}"><button>ตะกร้า</button></a>
                </div>
            @endguest
        </div>
    </section>
@endsection

@section('name_shop')
    <h2>เช่าพระ</h2>
@endsection

@section('content2')
    <div class="content2">

        @if ($products->isEmpty())
            <!-- แสดงหน้าตาเปล่าเมื่อไม่มีสินค้า -->
        @else
            <!-- แสดงรายการสินค้าหากมีสินค้า -->
            @foreach ($products as $product)
            <div id="product-list">

            </div>
            @endforeach
        @endif
            {{-- @foreach ($products as $product)
                <div class="card">
                    <div class="box">
                        <div class="img-box">
                            <a href="{{ route('products.show', $product->id) }}">
                                <button id="item{{ $product->id }}" class="button-wrapper">
                                    @if ($product->file_path_1)
                                        @php
                                            $fileExtension = pathinfo($product->file_path_1, PATHINFO_EXTENSION);
                                        @endphp
                                        @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                            <video width="100%" height="100%">
                                                <source src="{{ asset('storage/' . $product->file_path_1) }}"
                                                    type="video/{{ $fileExtension }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img id="img_item{{ $product->id }}"
                                                src="{{ asset('storage/' . $product->file_path_1) }}" alt="Product Image">
                                        @endif
                                    @else
                                        <img id="img_item{{ $product->id }}" src="path_to_default_image"
                                            alt="Product Image">
                                    @endif
                                </button>
                            </a>
                        </div>
                        <span>{{ $product->name }}</span>
                        <div class="amount">
                            <span id="amount-{{ $product->id }}">{{ $product->price }}</span>
                            <span> Bath</span>
                        </div>
                    </div>
                </div>

            @endforeach --}}
        
    </div>
    
@endsection
