<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/product_card.css">
    <link rel="stylesheet" href="css/profle.css">
    <link rel="stylesheet" href="css/mobile_filter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/add_item.css">
</head>

<body>
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>

        <div>
            <ul id="navbar">
                <li><a href="/">หน้าหลัก</a></li>
                <li><a href="shop">ซื้อพระ</a></li>
                <li><a href="auction">ประมูลพระ</a></li>
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
                    <a href="cart"><button>ตะกร้า</button></a>
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
        <a href="{{ route('profile.sell')}}" class="back"><button>
                <i class="fa fa-arrow-left"></i>back to sell
            </button></a>
        <div class="border">
            <form id="upload-form" method="POST" action="{{ route('profile.add_item') }}"
                enctype="multipart/form-data">
                @csrf
                @method ('post')
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="sec1">
                    <div class="add_img">
                        <div class="upfile">
                            <input type="file" id="actual-btn" name="img_vdo_1" accept="image/*, video/*" hidden />
                            <label for="actual-btn">Choose File</label>
                            <br>
                            <span id="file-chosen">No file chosen</span>
                            <button type="button" class="delete-btn" data-target="actual-btn">Delete</button>
                        </div>
                        <div class="upfile">
                            <input type="file" id="actual-btn2" name="img_vdo_2" accept="image/*, video/*" hidden />
                            <label for="actual-btn2">Choose File</label>
                            <br>
                            <span id="file-chosen2">No file chosen</span>
                            <button type="button" class="delete-btn" data-target="actual-btn2">Delete</button>
                        </div>
                        <div class="upfile">
                            <input type="file" id="actual-btn3" name="img_vdo_3" accept="image/*, video/*" hidden />
                            <label for="actual-btn3">Choose File</label>
                            <br>
                            <span id="file-chosen3">No file chosen</span>
                            <button type="button" class="delete-btn" data-target="actual-btn3">Delete</button>
                        </div>
                        <div class="upfile">
                            <input type="file" id="actual-btn4" name="img_vdo_4" accept="image/*, video/*"
                                hidden />
                            <label for="actual-btn4">Choose File</label>
                            <br>
                            <span id="file-chosen4">No file chosen</span>
                            <button type="button" class="delete-btn" data-target="actual-btn4">Delete</button>
                        </div>
                        <div class="upfile">
                            <input type="file" id="actual-btn5" name="img_vdo_5" accept="image/*, video/*"
                                hidden />
                            <label for="actual-btn5">Choose File</label>
                            <br>
                            <span id="file-chosen5">No file chosen</span>
                            <button type="button" class="delete-btn" data-target="actual-btn5">Delete</button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteButtons = document.querySelectorAll('.delete-btn');

                            deleteButtons.forEach(button => {
                                button.addEventListener('click', function() {
                                    const targetId = this.getAttribute('data-target');
                                    const fileInput = document.getElementById(targetId);
                                    const fileChosenSpan = document.querySelector(
                                        `#file-chosen${targetId.replace('actual-btn', '')}`);

                                    if (fileInput) {
                                        fileInput.value = ''; // Clear the file input
                                    }

                                    if (fileChosenSpan) {
                                        fileChosenSpan.textContent = 'No file chosen'; // Update the span text
                                    }
                                });
                            });
                        });

                        document.getElementById('upload-form').addEventListener('submit', function(event) {
                            const fileInput1 = document.getElementById('actual-btn');
                            if (!fileInput1.files.length) {
                                alert('กรุณาใส่รูปช่องที่ 1');
                                event.preventDefault(); // Prevent form submission
                            }
                        });
                    </script>



                    <div class="save_edit">
                        <button type="submit">บันทึก</button>
                    </div>
                </div>
                <div class="sec2">
                    <div class="left">
                        <div class="input_detail">
                            <span>ชื่อพระ</span>
                            <textarea type="text" name="name" placeholder="ใส่ชื่อพระ" required></textarea>
                        </div>
                        <div class="input_detail">
                            <span>ราคา</span>
                            <input type="number" name="price" value="" placeholder="ใส่ราคาพระ" required>
                        </div>
                        <div class="input_detail">
                            <span>อำเภอ</span>
                            <input name="selection_district" list="district" placeholder="เลือกอำเภอ" required>
                            <datalist id="district">
                                {!! app('App\Http\Controllers\ProductController')->getDistrictOptions() !!}
                            </datalist>
                        </div>
                        <div class="input_detail">
                            <span>หมวดหมู่</span>
                            <input name="selection_group" list="group" placeholder="เลือกหมวดหมู่" required>
                            <datalist id="group">
                                {!! app('App\Http\Controllers\ProductController')->getGroupOptions() !!}
                            </datalist>
                        </div>
                    </div>
                    <div class="right">
                        <div class="menu_select">
                            <span>ขาย</span>
                            <div class="switch">
                                <input type="checkbox" class="toggle_check" id="select_sale">
                                <label for="select_sale" class="rounded"></label>
                            </div>
                            <span>ประมูล</span>
                        </div>
                        <div class="date_time">
                            <div class="amount_sale">
                                <span>จำนวน</span>
                                <input type="number" name="quantity" min="0" max="100" value=""
                                    placeholder="ใส่จำนวนพระ" required>
                            </div>
                            <div class="date">
                                <label for="select_date">เลือกวันที่</label>
                                <input type="date" id="select_date" name="date">
                            </div>
                            <div class="time">
                                <label for="select_time">เลือกเวลา</label>
                                <input type="time" id="select_time" name="time">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sec3">
                    <div class="left">
                        <span>รายละเอียดเพิ่มเติม </span>
                        <textarea class="profile-text" placeholder="กรอกรายละเอียดเพิ่มเติม" name="description"></textarea>
                    </div>
                    <div class="right">
                        <h4>Payment Method</h4>
                        <div class="pm">
                            <h6>Cash on delivery</h6>
                            <img src="Component Pic/cash on delivery.png" alt="">
                            <input type="hidden" name="payment_method_1" value="0">
                            <div class="switch">
                                <input type="checkbox" name="payment_method_1" value="1" class="toggle_check"
                                    id="select_payment1">
                                <label for="select_payment1" class="rounded"></label>
                            </div>
                        </div>
                        <div class="pm">
                            <h6>Mobile Bank</h6>
                            <img src="Component Pic/mobile bank.png" alt="">
                            <input type="hidden" name="payment_method_2" value="0">

                            <div class="switch">
                                <input type="checkbox" name="payment_method_2" value="1" class="toggle_check"
                                    id="select_payment2">
                                <label for="select_payment2" class="rounded"></label>
                            </div>
                        </div>
                        <div class="pm">
                            <h6>True Money Wallet</h6>
                            <img src="Component Pic/true money wallet.png" alt="">
                            <input type="hidden" name="payment_method_3" value="0">
                            <div class="switch">
                                <input type="checkbox" name="payment_method_3" value="1" class="toggle_check"
                                    id="select_payment3">
                                <label for="select_payment3" class="rounded"></label>
                            </div>
                        </div>
                        <div class="pm">
                            <h6>Scheduled Pickup</h6>
                            <img src="Component Pic/Scheduled Pickup.png" alt="">
                            <input type="hidden" name="payment_method_4" value="0">
                            <div class="switch">
                                <input type="checkbox" name="payment_method_4" value="1" class="toggle_check"
                                    id="select_payment4">
                                <label for="select_payment4" class="rounded"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sec4">
                    <div class="save_edit">
                        <button>บันทึก</button>
                    </div>
                </div>
            </form>

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
    <script src="/js/script.js"></script>
    <script src="/js/upload.js"></script>
    <script src="/js/add_card.js"></script>
    <script src="/js/add_item.js"></script>
</body>

</html>
