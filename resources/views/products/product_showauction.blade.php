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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
                <li><a href="{{ route('products.shop') }}">ซื้อพระ</a></li>
                <li><a class="active link" href="{{ route('products.auction') }}">ประมูลพระ</a></li>
                @guest
                    <li><a href="{{ route('auth.register') }}">สมัครสมาชิก</a></li>
                    <li><a href="{{ route('auth.login') }}">เข้าสู่ระบบ</a></li>
                @else
                    <li><a class="cart_profile" href="{{ route('cart.show') }}"><img
                                src="{{ asset('Component Pic/Cart.png') }}" width="30" height="30"></a></li>
                    <li><a class="cart_profile" href="{{ route('profile.edit') }}"><img
                                src="{{ asset(Auth::user()->profile_img ?? 'Profile Pic/default.png') }}"
                                width="30" height="30" style="border-radius: 50%; object-fit: cover;"></a></li>
                @endguest
                <button id="navbarButton"><i class="fa fa-bars"></i></button>
            </ul>
        </div>
        <div id="navbar2">
            <div class="close_menu">
                <button id="closeMenuButton"><i  class="fa fa-times"></i></button>
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
                <h4 id="currentPriceDisplay">{{ intval($auction->top_price) }} Bath</h4>
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
                    <input class="input_auction" type="number" id="bidAmount" name="product-qty"
                        min="1">
                    <button class="addBit">Bid</i></button>
                </div>
                <div class="buyNow">
                    <button id="buyNowButton" class="buy_now">ซื้อทันที</button>
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
                    <button class="go_profile"
                        onclick="window.location.href='{{ route('rate_star', ['id' => $user->id, 'product_id' => $product->id, 'source' => 'auction']) }}'">
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
                <li><a href=""><img src="{{ asset('Component Pic/facebook.webp') }}" alt=""></a>
                </li>
                <li><a href=""><img src="{{ asset('Component Pic/ig.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/email.png') }}" alt=""></a></li>
            </ul>
        </div>
        <div class="contact">
            <p>PATTARADON WONGCHAI</p>
            <ul>
                <li><a href=""><img src="{{ asset('Component Pic/facebook.webp') }}" alt=""></a>
                </li>
                <li><a href=""><img src="{{ asset('Component Pic/ig.webp') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/email.png') }}" alt=""></a></li>
            </ul>
        </div>
        <div class="contact">
            <p>LAMPANG RAJABHAT UNIVERSITY</p>
            <ul>
                <li><a href=""><img src="{{ asset('Component Pic/facebook.webp') }}" alt=""></a>
                </li>
                <li><a href=""><img src="{{ asset('Component Pic/www.png') }}" alt=""></a></li>
                <li><a href=""><img src="{{ asset('Component Pic/email.png') }}" alt=""></a></li>
            </ul>
        </div>
    </section>
    <script src="{{ asset('/js/script2.js') }}"></script>
    <script src="{{ asset('https://kit.fontawesome.com/d671ca6a52.js') }}" crossorigin="anonymous"></script>

    <script>
        const User = @json($user); // ดึงข้อมูล product
        const sellId = User.id;
        const userId = User.username;
        const Auction = @json($auction);
        const buyNowButton = document.getElementById('buyNowButton'); // สมมุติว่าเป็น ID ของปุ่ม "ซื้อทันที"


        const LoginAuth =
            {{ auth()->check() ? auth()->user()->id : 0 }}; // เก็บค่า ID ของผู้ใช้ที่ล็อกอิน หรือ 0 หากไม่ได้ล็อกอิน
        console.log('Current Id: ', LoginAuth);

        const auctionButton = document.getElementById('auctionButton'); // ดึงปุ่มประมูลพระ
        const chatButton = document.querySelector('.chat'); // ดึงปุ่มแชทกับผู้ขาย
        // if (LoginAuth === sellId) {
        //     auctionButton.disabled = true;
        //     chatButton.disabled = true; // ปิดการใช้งานปุ่มแชท
        // }
        console.log('LoginAuth', LoginAuth);
        console.log('sellId', sellId);

        document.addEventListener("DOMContentLoaded", function() {
            var mainMedia = document.getElementById("main_media");
            var otherImages = document.querySelectorAll(".other_img");

            otherImages.forEach(function(img) {
                img.addEventListener("click", function() {
                    var videoTag = this.querySelector("video");
                    if (videoTag) {
                        mainMedia.outerHTML = '<video id="main_media" controls loop><source src="' +
                            videoTag.querySelector("source").src + '" type="video/' + videoTag
                            .querySelector("source").type.split('/')[1] + '"></video>';
                    } else {
                        mainMedia.outerHTML = '<img id="main_media" src="' + this.querySelector(
                            "img").src + '" alt="Product Image">';
                    }
                });
            });

            // ฟังก์ชันสำหรับการนับถอยหลัง
            function startCountdown(endDate, countdownElementId) {
                var countdownElement = document.getElementById(countdownElementId);
                var addBitButton = document.querySelector('.addBit'); // ดึงปุ่มประมูล

                function updateCountdown() {
                    var now = new Date();
                    var timeRemaining = endDate - now;

                    if (timeRemaining > 0) {
                        buyNowButton.disabled = true; // ถ้ามีเวลาเหลือ ให้ปิดการใช้งานปุ่ม
                    } else {
                        buyNowButton.disabled = false; // ถ้าเวลาน้อยกว่าหรือเท่ากับ 0 ให้เปิดใช้งานปุ่ม
                    }

                    if (timeRemaining <= 0) {
                        clearInterval(interval);
                        addBitButton.disabled = true;
                        updateCurrentPrice((currentPrice, currentWinner) => {
                            if (LoginAuth === currentWinner) {
                                countdownElement.innerHTML = "หมดเวลา (คุณเป็นผู้ชนะ)";
                            } else {
                                countdownElement.innerHTML = "หมดเวลา (คุณไม่ใช่ผู้ชนะ)";
                            }
                        });
                        return;
                    }

                    var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    countdownElement.innerHTML = days + " วัน " + hours.toString().padStart(2, '0') + ":" + minutes
                        .toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
                }

                var interval = setInterval(updateCountdown, 1000);
                updateCountdown(); // เรียกใช้งานทันทีเมื่อฟังก์ชันถูกเรียก
            }

            var endDate = new Date("{{ $product->date }}T{{ $product->time }}");
            startCountdown(endDate, "countdown");

            // ฟังก์ชันสำหรับการส่งข้อความ
            function sendChatMessage(productName, productImage, productPrice, currentUrl, userId, recipient) {
                const message = ''; // สามารถกำหนดข้อความเริ่มต้น หรือปล่อยว่าง
                console.log('Sending message:', {
                    sender: recipient, // ใช้ sellerId แทน userId
                    recipient: sellId,
                    product_name: productName,
                    product_image: productImage
                });

                const product = {
                    product_name: productName,
                    product_image: productImage,
                    product_price: parseFloat(productPrice),
                    current_url: currentUrl,
                    seller_id: userId
                };

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                console.log('CSRF Token:', csrfToken);
                axios.post('/store-message', {
                        sender: recipient, // ผู้ส่ง (ที่ได้จาก auth)
                        recipient: sellId,  // ผู้รับ (currentWinner)
                        message: message, // ข้อความแชท
                        ...product // ส่งข้อมูลสินค้าไปด้วย
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // เพิ่ม token ใน headers
                        }
                    })
                    .then(response => {
                        console.log('Message sent:', response.data);
                    })
                    .catch(error => {
                        console.error('Error sending message:', error.message);
                        if (error.response) {
                            console.error('Response data:', error.response
                                .data); // ตรวจสอบ response data ที่ทำให้เกิดข้อผิดพลาด
                            console.error('Response status:', error.response.status);
                        }
                    });
            }

            const bid = (productId, topPrice, winnerId) => {
                fetch('/bid', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            top_price: topPrice,
                            winner: winnerId,
                        }),
                    })
                    .then(response => {
                        const contentType = response.headers.get('content-type');
                        if (!response.ok || !contentType.includes('application/json')) {
                            throw new Error('Network response was not ok or not JSON');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        alert('ประมูลเรียบร้อยแล้ว!');
                        updateCurrentPrice();
                    })
                    .catch(error => console.error('Error:', error));


            };

            const addBitButton = document.querySelector('.addBit');
            const bidAmountInput = document.getElementById('bidAmount');

            // สมมุติว่าคุณได้ส่งราคาปัจจุบันจาก Blade Template
            const currentPrice = parseFloat('{{ $auction->top_price }}'); // ใช้ชื่อคอลัมน์ top_price
            const currentPriceDisplay = document.getElementById('currentPriceDisplay');
            currentPriceDisplay.textContent = currentPrice + ' Bath';

            // แสดงค่าปัจจุบันในฐานข้อมูลใน console
            console.log('ราคาปัจจุบันในฐานข้อมูล:', currentPrice);

            addBitButton.addEventListener('click', function() {

                if (LoginAuth === 0) {
                    // ถ้ายังไม่ได้ล็อกอิน เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
                    window.location.href = '/login'; // ปรับ URL ตามเส้นทางที่ใช้ในโปรเจคของคุณ
                    return; // หยุดการทำงานของฟังก์ชัน
                }
                const productId = {{ $product->id }}; // ใช้ ID ของผลิตภัณฑ์
                const topPrice = parseInt(bidAmountInput.value); // รับค่าจาก input
                const winnerId = {{ $user->id }}; // ใช้ ID ของผู้ประมูล

                if (LoginAuth === sellId) {
                    alert('คุณไม่สามารถประมูลสินค้าของตัวเองได้'); // แจ้งเตือนหากเป็นผู้ขาย
                    return; // หยุดการทำงานของฟังก์ชัน
                }

                if (!isNaN(topPrice) && topPrice > currentPrice) { // ตรวจสอบค่าราคา
                    bid(productId, topPrice, winnerId); // เรียกใช้ฟังก์ชัน bid
                } else if (topPrice <= currentPrice) {
                    alert(
                        'ราคาประมูลต้องมากกว่าราคาในปัจจุบัน!'
                    ); // แจ้งเตือนเมื่อราคาต่ำกว่าหรือเท่ากับราคาปัจจุบัน
                } else {
                    alert('กรุณากรอกราคาให้ถูกต้อง'); // แจ้งเตือนเมื่อกรอกค่าที่ไม่ถูกต้อง
                }
            });

            let hasMessageSentOnEnd = false; // ตัวแปรเพื่อตรวจสอบการส่งข้อความเมื่อเวลาหมด

            function updateCurrentPrice(callback) { // รับ callback เป็นพารามิเตอร์
                fetch(`/auction/current-price/{{ $product->id }}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const currentPrice = parseFloat(data.top_price);
                        currentPriceDisplay.textContent = currentPrice + ' Bath'; // อัปเดตราคาใหม่
                        console.log('ราคาที่อัปเดต:', currentPrice);
                        const currentWinner = parseInt(data.winner);
                        console.log('ผู้ชนะที่อัปเดต:', currentWinner);

                        // เรียก callback พร้อมกับ currentPrice และ currentWinner
                        if (typeof callback === 'function') {
                            callback(currentPrice, currentWinner);
                        } else {
                            console.error('callback is not a function');
                        }
                    })
                    .catch(error => console.error('Error fetching current price:', error));
            }

            function buyNow() {
                const currentUrl = window.location.href;
                const productImage = '{{ asset('storage/' . $product->file_path_1) }}';
                const productName = '{{ $product->name }}';

                updateCurrentPrice((currentPrice, currentWinner) => {
                    const recipient = currentWinner; // ใช้ currentWinner เป็นผู้รับ
                    const productPrice = currentPrice; // ใช้ currentPrice เป็นราคาสินค้า

                    // ตรวจสอบว่า LoginAuth เท่ากับ currentWinner หรือไม่
                    if (LoginAuth === currentWinner) {
                        sendChatMessage(productName, productImage, productPrice, currentUrl, userId,recipient);
                        const chatUrl2 =`/chat?sellId=${encodeURIComponent(sellId)}&seller_id=${encodeURIComponent(userId)}`; // สร้าง URL สำหรับหน้าแชท
                        window.location.href =chatUrl2;
                    } else {
                        alert(
                            'คุณไม่สามารถซื้อสินค้านี้ได้ เนื่องจากคุณไม่ใช่ผู้ชนะในการประมูล'
                        ); // แจ้งเตือนผู้ใช้
                    }
                });
            }
            if (buyNowButton) {
                buyNowButton.addEventListener('click', buyNow);
            }

            chatButton.addEventListener('click', function() {
                const chatUrl =
                    `/chat?sellId=${encodeURIComponent(sellId)}&seller_id=${encodeURIComponent(userId)}`; // สร้าง URL สำหรับหน้าแชท
                window.location.href =
                    chatUrl; // เปลี่ยนเส้นทางไปยังหน้าแชทพร้อมกับ user_id และ username ของผู้ขาย
            });

            // เรียกใช้งานฟังก์ชันอัปเดตราคาเป็นระยะ ๆ
            var interval2 = setInterval(updateCurrentPrice, 500);
        });
    </script>


</body>

</html>
