<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile_filter.css') }}">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_item.css') }}">
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
        <a href="{{ route('profile.sell') }}" class="back"><button>
                <i class="fa fa-arrow-left"></i>back to sell
            </button></a>
        <div class="border">
            <form id="upload-form" method="POST" action="{{ route('products.update', $product->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="sec1">
                    <div class="add_img">
                        <!-- img_vdo_1 -->
                        <div class="upfile">
                            <input type="file" id="actual-btn" name="img_vdo_1" accept="image/*, video/*" hidden />
                            <label for="actual-btn">Choose File</label>
                            <br>
                            <span
                                id="file-chosen">{{ $product->file_path_1 ? basename($product->file_path_1) : 'No file chosen' }}</span>
                            <input type="hidden" class="file-path" name="existing_file_1"
                                value="{{ $product->file_path_1 }}">
                            <button type="button" class="delete-btn" data-target="actual-btn"
                                data-filepath="{{ $product->file_path_1 }}">Delete</button>
                        </div>
                        <!-- img_vdo_2 -->
                        <div class="upfile">
                            <input type="file" id="actual-btn2" name="img_vdo_2" accept="image/*, video/*" hidden />
                            <label for="actual-btn2">Choose File</label>
                            <br>
                            <span
                                id="file-chosen2">{{ $product->file_path_2 ? basename($product->file_path_2) : 'No file chosen' }}</span>
                            <input type="hidden" class="file-path" name="existing_file_2"
                                value="{{ $product->file_path_2 }}">
                            <button type="button" class="delete-btn" data-target="actual-btn2"
                                data-filepath="{{ $product->file_path_2 }}">Delete</button>
                        </div>
                        <!-- img_vdo_3 -->
                        <div class="upfile">
                            <input type="file" id="actual-btn3" name="img_vdo_3" accept="image/*, video/*"
                                hidden />
                            <label for="actual-btn3">Choose File</label>
                            <br>
                            <span
                                id="file-chosen3">{{ $product->file_path_3 ? basename($product->file_path_3) : 'No file chosen' }}</span>
                            <input type="hidden" class="file-path" name="existing_file_3"
                                value="{{ $product->file_path_3 }}">
                            <button type="button" class="delete-btn" data-target="actual-btn3"
                                data-filepath="{{ $product->file_path_3 }}">Delete</button>
                        </div>
                        <!-- img_vdo_4 -->
                        <div class="upfile">
                            <input type="file" id="actual-btn4" name="img_vdo_4" accept="image/*, video/*"
                                hidden />
                            <label for="actual-btn4">Choose File</label>
                            <br>
                            <span
                                id="file-chosen4">{{ $product->file_path_4 ? basename($product->file_path_4) : 'No file chosen' }}</span>
                            <input type="hidden" class="file-path" name="existing_file_4"
                                value="{{ $product->file_path_4 }}">
                            <button type="button" class="delete-btn" data-target="actual-btn4"
                                data-filepath="{{ $product->file_path_4 }}">Delete</button>
                        </div>
                        <!-- img_vdo_5 -->
                        <div class="upfile">
                            <input type="file" id="actual-btn5" name="img_vdo_5" accept="image/*, video/*"
                                hidden />
                            <label for="actual-btn5">Choose File</label>
                            <br>
                            <span
                                id="file-chosen5">{{ $product->file_path_5 ? basename($product->file_path_5) : 'No file chosen' }}</span>
                            <input type="hidden" class="file-path" name="existing_file_5"
                                value="{{ $product->file_path_5 }}">
                            <button type="button" class="delete-btn" data-target="actual-btn5"
                                data-filepath="{{ $product->file_path_5 }}">Delete</button>
                        </div>
                    </div>


                    <!-- Hidden inputs for files to be deleted -->
                    <div id="delete-files-container">
                        <!-- Hidden inputs for file paths to be deleted will be added here by JavaScript -->
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteButtons = document.querySelectorAll('.delete-btn');

                            deleteButtons.forEach(button => {
                                button.addEventListener('click', function() {
                                    const targetId = this.getAttribute('data-target');
                                    const fileInput = document.getElementById(targetId);
                                    const fileIndex = targetId.replace('actual-btn',
                                        ''); // Get the index from the ID
                                    const fileChosenSpan = document.getElementById(`file-chosen${fileIndex}`);
                                    const filePath = this.getAttribute('data-filepath');

                                    if (fileInput) {
                                        fileInput.value = ''; // Clear the file input
                                    }

                                    if (fileChosenSpan) {
                                        fileChosenSpan.textContent = 'No file chosen'; // Update the span text
                                    }

                                    // Mark the file for deletion
                                    let existingFileInput = document.querySelector(
                                        `input[name="delete_file[]"][value="${filePath}"]`);
                                    if (!existingFileInput && filePath) {
                                        existingFileInput = document.createElement('input');
                                        existingFileInput.type = 'hidden';
                                        existingFileInput.name = 'delete_file[]';
                                        existingFileInput.value = filePath;
                                        document.getElementById('delete-files-container').appendChild(
                                            existingFileInput);
                                    }
                                });
                            });

                            document.querySelectorAll('input[type="file"]').forEach(input => {
                                input.addEventListener('change', function() {
                                    const spanId = this.id.replace('actual-btn', ''); // Get the index from the ID
                                    const span = document.getElementById(`file-chosen${spanId}`);
                                    if (this.files.length > 0) {
                                        span.textContent = this.files[0].name;
                                    } else {
                                        span.textContent = 'No file chosen';
                                    }
                                });
                            });

                            document.getElementById('upload-form').addEventListener('submit', function(event) {
                                let errorMessage = '';

                                // Check if file input 1 is missing
                                const fileInput1 = document.getElementById('actual-btn');
                                const existingFileInput1 = document.querySelector('input[name="existing_file_1"]');
                                const deleteFileInputs = Array.from(document.querySelectorAll(
                                    'input[name="delete_file[]"]'));
                                const existingFilePath1 = existingFileInput1 ? existingFileInput1.value : '';
                                const isFileDeleted1 = deleteFileInputs.some(input => input.value === existingFilePath1);

                                // Check if file input 1 is required and has been deleted without re-uploading
                                if (isFileDeleted1 && !fileInput1.files.length) {
                                    errorMessage = 'กรุณาใส่รูปช่องที่ 1';
                                }

                                if (errorMessage) {
                                    alert(errorMessage);
                                    event.preventDefault(); // Prevent form submission
                                }
                            });
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
                            <textarea type="text" name="name" placeholder="ใส่ชื่อพระ" required>{{ old('name', $product->name) }}</textarea>
                        </div>
                        <div class="input_detail">
                            <span>ราคา</span>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                placeholder="ใส่ราคาพระ" required>
                        </div>
                        <div class="input_detail">
                            <span>อำเภอ</span>
                            <input name="selection_district" list="district" placeholder="เลือกอำเภอ"
                                value="{{ old('selection_district', $product->selection_district) }}" required>
                            <datalist id="district">
                                {!! app('App\Http\Controllers\ProductController')->getDistrictOptions() !!}
                            </datalist>
                        </div>
                        <div class="input_detail">
                            <span>หมวดหมู่</span>
                            <input name="selection_group" list="group" placeholder="เลือกหมวดหมู่"
                                value="{{ old('selection_group', $product->selection_group) }}" required>
                            <datalist id="group">
                                {!! app('App\Http\Controllers\ProductController')->getGroupOptions() !!}
                            </datalist>
                        </div>
                    </div>
                    <div class="right">
                        <div class="menu_select">
                            <span>ขาย</span>
                            <div class="switch">
                                <input type="checkbox" class="toggle_check" id="select_sale"
                                    {{ $product->is_sale ? 'checked' : '' }}>
                                <label for="select_sale" class="rounded"></label>
                            </div>
                            <span>ประมูล</span>
                        </div>
                        <div class="date_time">
                            <div class="amount_sale">
                                <span>จำนวน</span>
                                <input id="quantity" type="number" name="quantity" min="0" max="10000"
                                    value="" placeholder="ใส่จำนวนพระ" required>

                            </div>
                            <div class="date">
                                <label for="select_date">เลือกวันที่</label>
                                <input id="select_date" type="date" id="select_date" name="date"
                                    value="">
                            </div>
                            <div class="time">
                                <label for="select_time">เลือกเวลา</label>
                                <input id="select_time" type="time" id="select_time" name="time"
                                    value="{{ old('time', $product->time) }}">
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const quantityInput = document.querySelector('input[name="quantity"]');
                            const dateInput = document.querySelector('input[name="date"]');
                            const timeInput = document.querySelector('input[name="time"]');
                            const saleCheckbox = document.getElementById('select_sale');

                            function handleQuantityChange() {
                                if (quantityInput.value) {
                                    dateInput.value = '';
                                    timeInput.value = '';
                                }
                            }

                            function handleDateTimeChange() {
                                if (dateInput.value || timeInput.value) {
                                    quantityInput.value = '';
                                }
                            }

                            function handleSaleCheckboxChange() {
                                if (saleCheckbox.checked) {
                                    quantityInput.value = '';
                                } else {
                                    dateInput.value = '';
                                    timeInput.value = '';
                                }
                            }

                            quantityInput.addEventListener('input', handleQuantityChange);
                            dateInput.addEventListener('input', handleDateTimeChange);
                            timeInput.addEventListener('input', handleDateTimeChange);
                            saleCheckbox.addEventListener('change', handleSaleCheckboxChange);

                            // Initial trigger based on checkbox state
                            handleSaleCheckboxChange();
                        });
                    </script>

                </div>
                <div class="sec3">
                    <div class="left">
                        <span>รายละเอียดเพิ่มเติม </span>
                        <textarea class="profile-text" placeholder="กรอกรายละเอียดเพิ่มเติม" name="description">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="right">
                        <h4>Payment Method</h4>
                        <div class="pm">
                            <h6>Cash on delivery</h6>
                            <img src="{{ asset('Component Pic/cash on delivery.png') }}" alt="">
                            <input type="hidden" name="payment_method_1" value="0">
                            <div class="switch">
                                <input type="checkbox" name="payment_method_1" value="1" class="toggle_check"
                                    id="select_payment1">
                                <label for="select_payment1" class="rounded"></label>
                            </div>
                        </div>
                        <div class="pm">
                            <h6>Mobile Bank</h6>
                            <img src="{{ asset('Component Pic/mobile bank.png') }}" alt="">
                            <input type="hidden" name="payment_method_2" value="0">

                            <div class="switch">
                                <input type="checkbox" name="payment_method_2" value="1" class="toggle_check"
                                    id="select_payment2">
                                <label for="select_payment2" class="rounded"></label>
                            </div>
                        </div>
                        <div class="pm">
                            <h6>True Money Wallet</h6>
                            <img src="{{ asset('Component Pic/true money wallet.png') }}" alt="">
                            <input type="hidden" name="payment_method_3" value="0">
                            <div class="switch">
                                <input type="checkbox" name="payment_method_3" value="1" class="toggle_check"
                                    id="select_payment3">
                                <label for="select_payment3" class="rounded"></label>
                            </div>
                        </div>
                        <div class="pm">
                            <h6>Scheduled Pickup</h6>
                            <img src="{{ asset('Component Pic/Scheduled Pickup.png') }}" alt="">
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
    <script src="{{ asset('/js/script.js') }}"></script>
    <script src="{{ asset('/js/upload.js') }}"></script>
    <script src="{{ asset('/js/add_card.js') }}"></script>
    <script src="{{ asset('/js/add_item.js') }}"></script>
</body>

</html>
