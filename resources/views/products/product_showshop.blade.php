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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
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
        <a href="{{ route('products.shop') }}"><button>
                <i class="fa fa-arrow-left"></i>back to shop
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
                <div class="qty-input">
                    <input class="product-qty" type="number" name="product-qty" min="1"
                        max="{{ $product->quantity }}" value="1" id="product-qty">
                </div>
                {{-- <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputField = document.getElementById('product-qty');
                        const minQuantity = parseInt(inputField.getAttribute('min'));
                        const maxQuantity = parseInt(inputField.getAttribute('max'));

                        inputField.addEventListener('input', function() {
                            let value = parseInt(inputField.value);
                            if (!isNaN(value)) {
                                if (value < minQuantity) {
                                    inputField.value = minQuantity;
                                } else if (value > maxQuantity) {
                                    inputField.value = maxQuantity;
                                }
                            }
                        });

                        // Optional: To handle paste events
                        inputField.addEventListener('paste', function(event) {
                            setTimeout(() => {
                                let value = parseInt(inputField.value);
                                if (!isNaN(value)) {
                                    if (value < minQuantity) {
                                        inputField.value = minQuantity;
                                    } else if (value > maxQuantity) {
                                        inputField.value = maxQuantity;
                                    }
                                }
                            }, 100);
                        });
                    });
                </script> --}}
                <div class="addToCart">
                    <button class="addCart" data-product-id="{{ $product->id }}"
                        data-user-id="{{ Auth::id() }}" type="submit">เพิ่มในตะกร้า</button>
                    <button class="addWish" data-product-id="{{ $product->id }}"
                        data-user-id="{{ Auth::id() }}"><i class="far fa-heart"></i></button>
                </div>
                <div class="buyNow">
                    <button class="buy_now">ซื้อตอนนี้</button>
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
                    <button class="go_profile" onclick="window.location.href='{{ route('rate_star', ['id' => $user->id, 'product_id' => $product->id, 'source' => 'shop']) }}'">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zooming/2.1.1/zooming.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputField = document.getElementById('product-qty');
            const minQuantity = parseInt(inputField.getAttribute('min'));
            const maxQuantity = parseInt(inputField.getAttribute('max'));

            inputField.addEventListener('input', function() {
                let value = parseInt(inputField.value);
                if (isNaN(value) || value < minQuantity) {
                    inputField.value = minQuantity;
                } else if (value > maxQuantity) {
                    inputField.value = maxQuantity;
                }
            });

            inputField.addEventListener('paste', function(event) {
                setTimeout(() => {
                    let value = parseInt(inputField.value);
                    if (isNaN(value) || value < minQuantity) {
                        inputField.value = minQuantity;
                    } else if (value > maxQuantity) {
                        inputField.value = maxQuantity;
                    }
                }, 100);
            });

            document.querySelectorAll('.addCart').forEach(button => {
                button.addEventListener('click', function() {
                    let productId = this.getAttribute('data-product-id');
                    let userId = this.getAttribute('data-user-id');
                    let qtyInput = document.getElementById('product-qty');
                    let productQty = qtyInput ? qtyInput.value : 1;
                    let currentDate = new Date().toISOString(); // วันที่และเวลาปัจจุบัน

                    console.log('Product ID:', productId);
                    console.log('User ID:', userId);
                    console.log('Product Quantity:', productQty);
                    console.log('Current Date:', currentDate);

                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                user_id: userId,
                                product_qty: productQty,
                                add_cart_date: currentDate // ส่งวันที่และเวลาปัจจุบัน
                            })
                        })
                        .then(response => response.json())
                        .then(data => alert(data.message));
                });
            });

            const addWishBtns = document.querySelectorAll('.addWish');

            addWishBtns.forEach(addWishBtn => {
                const heartIcon = addWishBtn.querySelector('i');

                addWishBtn.addEventListener('click', function() {
                    let productId = this.getAttribute('data-product-id');
                    let userId = this.getAttribute('data-user-id');
                    let currentDate = new Date().toISOString(); // วันที่และเวลาปัจจุบัน


                    console.log('Product ID:', productId);
                    console.log('User ID:', userId);
                    // console.log('Product Quantity:', productQty);
                    console.log('Current Date:', currentDate);

                    if (heartIcon.classList.contains('far')) {
                        // Add to wishlist
                        fetch('{{ route('wishlist.add') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    product_id: productId,
                                    user_id: userId,
                                    add_wish_list_date: currentDate // ส่งวันที่และเวลาปัจจุบัน
                                })
                            })
                            .then(response => response.json())
                            .then(data => alert(data.message));

                        heartIcon.classList.remove('far');
                        heartIcon.classList.add('fas');
                    } else {
                        // Remove from wishlist
                        fetch('{{ route('wishlist.remove') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    product_id: productId,
                                    user_id: userId
                                })
                            })
                            .then(response => response.json())
                            .then(data => alert(data.message));

                        heartIcon.classList.remove('fas');
                        heartIcon.classList.add('far');
                    }
                });
            });
        });
    </script>

</body>

</html>
