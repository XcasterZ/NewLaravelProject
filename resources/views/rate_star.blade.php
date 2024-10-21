<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product_card.css') }}">

    <link rel="stylesheet" href="{{ asset('css/mobile_filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rate_star.css') }}">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>

        <div>
            <ul id="navbar">
                <li><a href="{{ route('home') }}">หน้าหลัก</a></li>
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

    <section class="container">
        <a href="{{ $source === 'shop' ? route('product.showshop', ['id' => $product_id]) : route('auction.show', ['id' => $product_id]) }}"
            style="text-decoration: none;">
            <button style="width: 120px;">
                <i class="fa fa-arrow-left"></i>back
            </button>
        </a>
        <div class="grid">
            <div class="profile_content1">
                <div class="user_img">
                    <div class="profile_img">
                        <img src="{{ asset($user->profile_img) }}" id="output" width="200"
                            style="border-radius: 50%;" />
                    </div>
                    <h4>
                        @if (!empty($user->first_name) && !empty($user->last_name))
                            {{ $user->first_name }} {{ $user->last_name }}
                        @else
                            {{ $user->username }}
                        @endif
                    </h4>
                    <div class="show_star" style="pointer-events: none;">
                        <p>
                            <span class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label for="rate-{{ $i }}" style="--i:{{ $i }}">
                                        <i class="fa-solid fa-star" style="color: {{ $i <= $averageRating ? '#faec1b' : '#d3d3d3' }};"></i>
                                    </label>
                                @endfor
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="detail">
                <div class="more_details">
                    <span>{{ $user->profile_detail }}</span>
                </div>
                <div class="contact">
                    <h4>เบอร์โทร</h4>
                    <span>{{ $user->phone_number }}</span>
                    <h4>E-mail</h4>
                    <span>{{ $user->email }}</span>
                    <div class="another_contact">
                        <!-- Instagram -->
                        @if (!empty($user->instagram))
                            <a href="{{ $user->instagram }}" target="_blank">
                                <img src="{{ asset('Component Pic/instagram.png') }}" alt="Instagram">
                            </a>
                        @endif

                        <!-- Facebook -->
                        @if (!empty($user->facebook))
                            <a href="{{ $user->facebook }}" target="_blank">
                                <img src="{{ asset('Component Pic/fb.png') }}" alt="Facebook">
                            </a>
                        @endif

                        <!-- Line -->
                        @if (!empty($user->line))
                            <a href="{{ $user->line }}" target="_blank">
                                <img src="{{ asset('Component Pic/line.png') }}" alt="Line">
                            </a>
                        @endif
                    </div>
                </div>

            </div>
            <div class="rate_star">
                <h4>ให้คะแนน</h4>
                <p><span class="star-rating">
                        <label for="rate-1" style="--i:1"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" name="rating" id="rate-1" value="1">
                        <label for="rate-2" style="--i:2"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" name="rating" id="rate-2" value="2">
                        <label for="rate-3" style="--i:3"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" name="rating" id="rate-3" value="3">
                        <label for="rate-4" style="--i:4"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" name="rating" id="rate-4" value="4">
                        <label for="rate-5" style="--i:5"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" name="rating" id="rate-5" value="5">
                    </span></p>
                <style>
                    .star-rating {
                        white-space: nowrap;
                    }

                    .star-rating [type="radio"] {
                        appearance: none;
                    }

                    .star-rating i {
                        font-size: 1.2em;
                        transition: 0.3s;
                    }

                    .star-rating label:is(:hover, :has(~ :hover)) i {
                        transform: scale(1.35);
                        color: #fffdba;
                        animation: jump 0.5s calc(0.3s + (var(--i) - 1) * 0.15s) alternate infinite;
                    }

                    .star-rating label:has(~ :checked) i {
                        color: #faec1b;
                        text-shadow: 0 0 2px #ffffff, 0 0 10px #ffee58;
                    }

                    @keyframes jump {

                        0%,
                        50% {
                            transform: translatey(0) scale(1.35);
                        }

                        100% {
                            transform: translatey(-15%) scale(1.35);
                        }
                    }
                </style>
            </div>
        </div>

    </section>

    <section id="footer">
        <div class="contact">
            <p>PORNSAWAN PRAMAN</p>
            <ul>
                <li><a href=""><img src="{{ asset('Component Pic/facebook.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/ig.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/email.png') }}" alt=""></a></li>
            </ul>
        </div>
        <div class="contact">
            <p>PATTARADON WONGCHAI</p>
            <ul>
                <li><a href=""><img src="{{ asset('Component Pic/facebook.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/ig.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/email.png') }}" alt=""></a></li>
            </ul>
        </div>
        <div class="contact">
            <p>LAMPANG RAJABHAT UNIVERSITY</p>
            <ul>
                <li><a href=""><img src="{{ asset('Component Pic/facebook.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/www.png') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/email.png') }}" alt=""></a></li>
            </ul>
        </div>
    </section>
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

            var filter_menu_btn = document.getElementById("filter_menu");
            var closeMenuButton_filter = document.getElementById("closeMenuButton_filter");
            var navbar2 = document.getElementById("navbar2");

            filter_menu_btn.addEventListener("click", function() {
                mobile_filter.classList.add("active");
                document.body.style.overflow = "hidden";
            });

            closeMenuButton_filter.addEventListener("click", function() {
                mobile_filter.classList.remove("active");
                document.body.style.overflow = "auto";
            });
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // เมื่อมีการเลือกดาว
            document.querySelectorAll('.star-rating input[type="radio"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    let rating = this.value;
                    let userId = "{{ $user->id }}"; // ใช้ user_id แทน product_id
                    let source = "{{ $source }}"; // ใช้ source ตามที่ต้องการ
    
                    console.log('Sending rating:', {
                        rating: rating,
                        user_id: userId, // ส่ง user_id
                        source: source
                    });
    
                    // ส่งข้อมูลไปยังเซิร์ฟเวอร์
                    fetch("{{ route('submit_rating', ['id' => $user->id]) }}", { // ส่งไปยัง route ที่ใช้ user_id
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            rating: rating,
                            user_id: userId, // ส่ง user_id
                            source: source
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Rating submitted successfully', data);
                        } else {
                            console.error('Failed to submit rating', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
    
    
    


</body>

</html>
