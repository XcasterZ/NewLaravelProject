@extends('shop_layout')
@section('title', 'auction')
@section('header')
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>

        <div>
            <ul id="navbar">
                <li><a href="{{ route('home') }}">หน้าหลัก</a></li>
                <li><a href="{{ route('products.shop') }}">ซื้อพระ</a></li>
                <li><a class="active link" href="{{ route('products.auction') }}">ประมูลพระ</a></li>
                @guest
                    <li><a href="{{ route('auth.register') }}">สมัครสมาชิก</a></li>
                    <li><a href="{{ route('auth.login') }}">เข้าสู่ระบบ</a></li>
                @else
                    <li><a class="cart_profile" href="{{ route('cart.show') }}"><img src="Component Pic/Cart.png" width="30"
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
                <a href="{{ route('products.shop') }}"><button>ซื้อพระ</button></a>
            </div>
            <div class="box_menu">
                <a href="{{ route('products.auction') }}"><button class="active_menu">ประมูลพระ</button></a>
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
    <h2>ประมูลพระ</h2>
@endsection

@section('content2')
    <div class="content2">
        @foreach ($products as $product)
            @php
                $now = new \DateTime();
                $endDateTime = new \DateTime($product->date . ' ' . $product->time);
            @endphp

            @if ($endDateTime > $now)

                <div id="product-list2">

                </div>
            @endif
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateCountdown() {
                document.querySelectorAll('.countdown').forEach(function (element) {
                    const date = element.getAttribute('data-date');
                    const time = element.getAttribute('data-time');
                    const targetDateTime = new Date(`${date}T${time}`);
                    const now = new Date();
                    const difference = targetDateTime - now;
                    
                    if (difference <= 0) {
                        element.innerHTML = 'หมดเวลา';
                        // element.parentElement.parentElement.style.display = 'none'; // Hide the entire card
                        return;
                    }

                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                    element.innerHTML = `${days} วัน ${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที`;
                });
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
@endsection
