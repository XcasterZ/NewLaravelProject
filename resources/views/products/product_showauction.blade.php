<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/zoom.js/2.0.0/zoom.min.css') }}">
    <!-- <link rel="stylesheet" href="css/quantity.scss"> -->
</head>

<body>
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>

        <div>
            <ul id="navbar">
                <li><a href="{{ route('home') }}">หน้าหลัก</a></li>
                <li><a  href="{{ route('products.shop') }}">ซื้อพระ</a></li>
                <li><a class="active link" href="{{ route('products.auction') }}">ประมูลพระ</a></li>
                @guest
                    <li><a href="{{ route('auth.register') }}">สมัครสมาชิก</a></li>
                    <li><a href="{{ route('auth.login') }}">เข้าสู่ระบบ</a></li>
                @else
                    <li><a class="cart_profile" href="{{ route('cart.show') }}"><img src="{{ asset('Component Pic/Cart.png') }}"
                                width="30" height="30"></a></li>
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
                <a href="{{ route('products.shop') }}"><button >ซื้อพระ</button></a>
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

    <section class="product">
        <a href="{{ route('products.auction') }}"><button>
                <i class="fa fa-arrow-left" style="padding-right: 10px"></i>back to auction
            </button></a>
        <div class="product_container">
            <div class="image">
                <div class="main_image">
                    <div class="main_content">
                        @php
                            $defaultImage = $product->file_path_1;
                            $defaultFileExtension = pathinfo($defaultImage, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array($defaultFileExtension, ['mp4', 'webm', 'ogg']))
                            <video id="main_media" autoplay muted loop>
                                <source src="{{ asset('storage/' . $defaultImage) }}"
                                    type="video/{{ $defaultFileExtension }}">
                            </video>
                        @else
                            <img id="main_media" src="{{ asset('storage/' . $defaultImage) }}" alt="Product Image">
                        @endif

                    </div>
                </div>
                <div class="other_image">
                    @for ($i = 1; $i <= 5; $i++)
                        @php
                            $filePath = 'file_path_' . $i;
                            $fileExtension = pathinfo($product->$filePath, PATHINFO_EXTENSION);
                        @endphp
                        @if ($product->$filePath)
                            @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                <div class="other_img" id="media_{{ $i }}">
                                    <video autoplay loop muted>
                                        <source src="{{ asset('storage/' . $product->$filePath) }}"
                                            type="video/{{ $fileExtension }}">
                                    </video>
                                </div>
                            @else
                                <div class="other_img" id="media_{{ $i }}">
                                    <img src="{{ asset('storage/' . $product->$filePath) }}" alt="Product Image">
                                </div>
                            @endif
                        @endif
                    @endfor
                </div>
            </div>
            <div class="details">
                <h4>{{ $product->name }}</h4>
                <div class="product_details">
                    <p>{{ $product->description ?? 'No description available' }}</p>
                </div>
                <h4>{{ $product->price }} Bath</h4>
                <h4 id="countdown"></h4>
                <div class="payment_show">
                    @php
                        $paymentMethods = json_decode($product->payment_methods, true); // ถ้า payment_methods เป็น JSON
                    @endphp

                    @if (isset($paymentMethods['payment_method_1']) && $paymentMethods['payment_method_1'] === 'cash_on_delivery')
                        <img src="{{ asset('Component Pic/cash on delivery.png') }}" alt="Cash on Delivery">
                    @endif

                    @if (isset($paymentMethods['payment_method_2']) && $paymentMethods['payment_method_2'] === 'mobile_bank')
                        <img src="{{ asset('Component Pic/mobile bank.png') }}" alt="Mobile Bank">
                    @endif

                    @if (isset($paymentMethods['payment_method_3']) && $paymentMethods['payment_method_3'] === 'true_money_wallet')
                        <img src="{{ asset('Component Pic/true money wallet.png') }}" alt="True Money Wallet">
                    @endif

                    @if (isset($paymentMethods['payment_method_4']) && $paymentMethods['payment_method_4'] === 'scheduled_pickup')
                        <img src="{{ asset('Component Pic/Scheduled Pickup.png') }}" alt="Scheduled Pickup">
                    @endif
                </div>
                <div class="bit">
                    <div class="baht">฿</div>
                    <input class="input_auction" type="number" name="product-qty" min="1">
                    <button class="addBit">Bit</i></button>
                </div>
                <h4>
                    @if ($user->first_name && $user->last_name)
                        {{ $user->first_name }} {{ $user->last_name }}
                    @else
                        {{ $user->username }}
                    @endif
                </h4>
                <div class="product_details">
                    <p>{{ $user->profile_detail ?? 'No profile detail available' }}</p>
                </div>
                <h4>Email : {{ $user->email }}</h4>
                <h4>Phone : {{ $user->phone_number }}</h4>
                {{-- <div class="show_star">
                    <img src="{{ asset('Component Pic/star.png') }}" alt="">
                </div> --}}
                <div class="contact_show">
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

                <div class="addToCart">
                    <button class="chat">แชทกับผู้ขาย</button>
                    <button class="go_profile" onclick="window.location.href='{{ route('rate_star', ['id' => $user->id, 'product_id' => $product->id, 'source' => 'auction']) }}'">
                        <i class="fa fa-user"></i>
                    </button>                
                </div>
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
    <script src="{{ asset('/js/script2.js') }}"></script>
    <script src="{{ asset('https://kit.fontawesome.com/d671ca6a52.js') }}" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var mainMedia = document.getElementById("main_media");
            var otherImages = document.querySelectorAll(".other_img");

            otherImages.forEach(function(img) {
                img.addEventListener("click", function() {
                    var videoTag = this.querySelector("video");
                    if (videoTag) {
                        mainMedia.outerHTML = '<video id="main_media" controls loop><source src="' + videoTag.querySelector("source").src + '" type="video/' + videoTag.querySelector("source").type.split('/')[1] + '"></video>';
                    } else {
                        mainMedia.outerHTML = '<img id="main_media" src="' + this.querySelector("img").src + '" alt="Product Image">';
                    }
                });
            });

            function startCountdown(endDate, countdownElementId) {
                var countdownElement = document.getElementById(countdownElementId);

                function updateCountdown() {
                    var now = new Date();
                    var timeRemaining = endDate - now;

                    if (timeRemaining <= 0) {
                        countdownElement.innerHTML = "หมดเวลา";
                        clearInterval(interval);
                        return;
                    }

                    var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    countdownElement.innerHTML = days + " วัน " + hours.toString().padStart(2, '0') + ":" + minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
                }

                var interval = setInterval(updateCountdown, 1000);
                updateCountdown(); // initial call
            }

            var endDate = new Date("{{ $product->date }}T{{ $product->time }}");
            startCountdown(endDate, "countdown");
        });
    </script>


</body>

</html>
