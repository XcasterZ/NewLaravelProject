<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>

        <div>
            <ul id="navbar">
                <li><a class="active link" href="{{ route('home') }}">หน้าหลัก</a></li>
                <li><a href="{{ route('products.shop') }}">ซื้อพระ</a></li>
                <li><a href="{{ route('products.auction') }}">ประมูลพระ</a></li>
                @guest
                    <li><a href="{{ route('auth.register') }}">สมัครสมาชิก</a></li>
                    <li><a href="{{ route('auth.login') }}">เข้าสู่ระบบ</a></li>
                @else
                    <li><a class="cart_profile" href="{{ route('cart.show') }}"><img
                                src="{{ asset('Component Pic/Cart.png') }}" width="30" height="30"></a></li>
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
                <a href="{{ route('home') }}"><button class="active_menu">หน้าหลัก</button></a>
            </div>
            <div class="box_menu">
                <a href="{{ route('products.shop') }}"><button>ซื้อพระ</button></a>
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
                {{-- <div class="box_menu">
                    <a href="profile"><button>โปรไฟล์</button></a>
                </div> --}}
                <!-- Logout Form -->
                {{-- <div class="box_menu">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div> --}}
            @endguest
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var navbarButton = document.getElementById("navbarButton");
                var closeMenuButton = document.getElementById("closeMenuButton");
                var navbar2 = document.getElementById("navbar2");

                navbarButton.addEventListener("click", function() {
                    navbar2.classList.add("active");
                    document.body.style.overflow = "hidden";
                });

                closeMenuButton.addEventListener("click", function() {
                    navbar2.classList.remove("active");
                    document.body.style.overflow = "auto";
                });
            });
        </script>
    </section>
    <section id="hero">
        <div id="main_pic" style="overflow: hidden;">
            <img src="Component Pic/document.jpg" style="filter: blur(2px) grayscale(50%); transform: scale(1.2);">
            <div class="box_frame"></div>
            <h2>SADUAKPRA</h2>
            <a href="shop">SHOP NOW</a>
        </div>
    </section>

    <section id="slogan_bar">
        <div>
            <ul id="slogan">
                <li>ซื้อง่าย</li>
                <li>ขายง่าย</li>
                <li>ทุกที่</li>
                <li>ทุกเวลา</li>
            </ul>
        </div>
    </section>

    <section id="recommend">
        <div id="recommend_content">
            <h1>พระเครื่องแนะนำ</h1>
            <ul id="recommend_item">
                @foreach ($recommendedProducts as $product)
                    @php
                        // ดึงนามสกุลไฟล์จาก file_path_1
                        $fileExtension = pathinfo($product->file_path_1, PATHINFO_EXTENSION);
                    @endphp
                    <div class="item">
                        @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                            <div class="video-container">
                                <video autoplay muted loop>
                                    <source src="{{ asset('storage/' . $product->file_path_1) }}"
                                        type="video/{{ $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $product->file_path_1) }}" alt="">
                        @endif
                        <a href="{{ route('product.showshop', $product->id) }}">{{ $product->name }}</a>
                    </div>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="footer">
        <div class="contact">
            <p>PORNSAWAN PRAMAN</p>
            <ul>
                <li><a href=""><img src="Component Pic/facebook.webp" alt=""></a></li>
                <li><a href=""><img src="Component Pic/ig.webp" alt=""></a></li>
                <li><a href=""><img src="Component Pic/email.png" alt=""></a></li>
            </ul>
        </div>
        <div class="contact">
            <p>PATTARADON WONGCHAI</p>
            <ul>
                <li><a href=""><img src="Component Pic/facebook.webp" alt=""></a></li>
                <li><a href=""><img src="Component Pic/ig.webp" alt=""></a></li>
                <li><a href=""><img src="Component Pic/email.png" alt=""></a></li>
            </ul>
        </div>
        <div class="contact">
            <p>LAMPANG RAJABHAT UNIVERSITY</p>
            <ul>
                <li><a href=""><img src="Component Pic/facebook.webp" alt=""></a></li>
                <li><a href=""><img src="Component Pic/www.png" alt=""></a></li>
                <li><a href=""><img src="Component Pic/email.png" alt=""></a></li>
            </ul>
        </div>
    </section>
    <!-- <script src="script.js"></script> -->
</body>

</html>

<style>
    .video-container {
    position: relative;
    width: 100%;
    height: 100%;
    padding-bottom: 56.25%; /* อัตราส่วน 16:9 สำหรับวิดีโอ */
    overflow: hidden;
}

.video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* ทำให้วิดีโอเต็มพื้นที่ของ container */
    transition: transform 0.3s ease;

}

.video-container video:hover{
    transform: scale(1.1);

}
</style>
