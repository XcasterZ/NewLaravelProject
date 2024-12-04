@extends('profile_layout')
@section('title', 'profile')
@section('content2')
    <div class="profile_content2">
        @foreach ($products as $product)
            <div class="cart" data-product-id="{{ $product->id }}">
                <h4>
                    @php
                        $seller = $sellers[$product->user_id] ?? null;
                    @endphp
                    {{ $seller ? ($seller->first_name && $seller->last_name ? $seller->first_name . ' ' . $seller->last_name : $seller->username) : 'Seller Name' }}
                </h4>
                <div class="cart_product">
                    <div class="cart_img">
                        @if ($product->file_path_1)
                            @php
                                $fileExtension = pathinfo($product->file_path_1, PATHINFO_EXTENSION);
                                $route = null;
                                if (
                                    !is_null($product->quantity) &&
                                    is_null($product->date) &&
                                    is_null($product->time)
                                ) {
                                    $route = route('product.showshop', ['id' => $product->id]);
                                } elseif (
                                    !is_null($product->date) &&
                                    !is_null($product->time) &&
                                    is_null($product->quantity)
                                ) {
                                    $route = route('auction.show', ['id' => $product->id]);
                                }
                            @endphp

                            @if ($route)
                                <a href="{{ $route }}" target="_blank">
                                    @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                        <video width="320" height="240" autoplay muted loop>
                                            <source src="{{ asset('storage/' . $product->file_path_1) }}"
                                                type="video/{{ $fileExtension }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $product->file_path_1) }}" alt="">
                                    @endif
                                </a>
                            @else
                                <p>ไม่มีข้อมูลที่เกี่ยวข้อง</p>
                            @endif
                        @endif
                    </div>
                    <div class="grid_cart">
                        <div class="cart_name">
                            <p>{{ $product->name }}</p>
                        </div>
                        <div class="cart_price">
                            <p id="price-display-{{ $product->id }}">{{ $product->price }} บาท</p>
                        </div>
                        <div class="cart_qty">
                            <input class="product-qty" type="number" id="product-qty-{{ $product->id }}"
                                name="product-qty" min="1" max="{{ $product->quantity ?? 'null' }}"
                                value="{{ $productQuantities[$product->id] ?? 1 }}">
                        </div>
                    </div>
                </div>

                <div class="cart_total">
                    <div class="payment">
                        @php
                            $paymentMethods = json_decode($product->payment_methods, true); // ถ้า payment_methods เป็น JSON
                        @endphp

                        @if (isset($paymentMethods['payment_method_1']) && $paymentMethods['payment_method_1'] === 'cash_on_delivery')
                            <img src="{{ asset('Component Pic/cash on delivery.png') }}" alt="จ่ายเงินปลายทาง">
                        @endif

                        @if (isset($paymentMethods['payment_method_2']) && $paymentMethods['payment_method_2'] === 'mobile_bank')
                            <img src="{{ asset('Component Pic/mobile bank.png') }}" alt="ธนาคาร">
                        @endif

                        @if (isset($paymentMethods['payment_method_3']) && $paymentMethods['payment_method_3'] === 'true_money_wallet')
                            <img src="{{ asset('Component Pic/true money wallet.png') }}" alt="ทรูวอเล็ท">
                        @endif

                        @if (isset($paymentMethods['payment_method_4']) && $paymentMethods['payment_method_4'] === 'scheduled_pickup')
                            <img src="{{ asset('Component Pic/Scheduled Pickup.png') }}" alt="นัดรับ">
                        @endif

                        @if (isset($paymentMethods['payment_method_5']) && $paymentMethods['payment_method_5'] === 'QR_Code')
                            <img src="{{ asset('Component Pic/qr_code.png') }}" alt="QR code">
                        @endif

                        @if (isset($paymentMethods['payment_method_6']) && $paymentMethods['payment_method_6'] === 'API')
                            <img src="{{ asset('Component Pic/api.png') }}" alt="api">
                        @endif
                    </div>
                    <div class="payment_chat">
                        <button class="remove-product" data-product-id="{{ $product->id }}">ลบ</button>
                    </div>
                    <div class="payment_chat">
                        <button class="buy_now" data-sell-id="{{ $product->user_id }}"
                            data-username="{{ $seller ? $seller->username : 'Unknown' }}"
                            data-product-name="{{ $product->name }}"
                            data-product-image="{{ asset('storage/' . $product->file_path_1) }}"
                            data-product-quantity="{{ $productQuantities[$product->id] ?? 1 }}"
                            data-product-url="{{ $route }}">แชท</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <h4>เลือกช่องทางชำระเงิน</h4>
            <div class="payment-options">
                <!-- ช่องทางชำระเงินจะแสดงที่นี่ -->
            </div>
            <button id="cancelPayment" class="cancel-btn">ยกเลิก</button>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content2 modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบสินค้าออกจากตะกร้า</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    คุณต้องการลบสินค้านี้ออกจากตะกร้าหรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">ลบ</button>
                </div>
            </div>
        </div>
    </div>


    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
            border-radius: 8px;
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 10px;
        }


        .payment-options {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            max-width: 400px;
            align-items: center;
        }

        .payment-options button {
            display: flex;
            align-items: center;
            /* จัดแนวกลางแนวตั้ง */
            justify-content: flex-start;
            /* เริ่มจากซ้าย */
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: auto;
            /* ปรับความสูงให้พอดี */
            gap: 10px;
            /* ระยะห่างระหว่างรูปกับข้อความ */
        }

        .payment-options button img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            /* ปรับรูปภาพให้อยู่ในกรอบ */
        }

        .payment-options button span {
            flex-grow: 1;
            /* ให้ข้อความขยายตามพื้นที่ */
            text-align: left;
            /* จัดข้อความชิดซ้าย */
            font-size: 14px;
            /* ปรับขนาดตัวอักษร */
            color: white;
        }

        .cancel-btn {
            padding: 10px 15px;
            background-color: #b71e09;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: 50px;
        }

        .payment-options button img {
            width: 40px;
            height: 40px;
        }

        .confirm-btn {
            margin-top: 20px;
            background-color: #28a745;
        }

        .payment-options span {
            width: 90px;
            height: auto;

        }

        #cancelPayment {
            margin-top: 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            /* จัดแนวกลางแนวนอน */
            align-items: center;
            /* จัดแนวกลางแนวตั้ง */
            height: 50px;
            /* กำหนดความสูงของปุ่ม */
            width: auto;
            /* ให้ความกว้างเหมาะสมกับเนื้อหาภายใน */
        }

        .payment-options img {
            max-width: 50%;
            height: auto;

        }

        .payment-options textarea {
            width: 400px;
            resize: none;
            background-color: #C6C6C6;
            padding: 10px;
            height: 42px;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 1300px) {
            .payment-options textarea {
                width: 400px;
                resize: none;
                background-color: #C6C6C6;
                padding: 10px;
                height: 42px;
                border-radius: 5px;
                box-sizing: border-box;
                margin-bottom: 20px;
            }
        }

        @media screen and (max-width: 900px) {
            .payment-options textarea {
                width: 200px;
                resize: none;
                background-color: #C6C6C6;
                padding: 10px;
                height: 42px;
                border-radius: 5px;
                box-sizing: border-box;
                margin-bottom: 20px;
            }

            .modal-content {
                width: 80%
            }

            .payment-options img {
                max-width: 80%;
                height: auto;

            }

            .payment-options {
                width: 300px;
            }
        }
    </style>

    <style>
        .expired {
            color: red;
            font-weight: bold;
        }

        /* Modal Background */
        .custom-modals {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }


        /* Modal Content */
        .modal-content2 {
            background-color: #fefefe;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }


        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* ปรับแต่ง modal header */
        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }


        /* ปรับแต่งเนื้อหา modal */
        .modal-body {
            padding: 1.5rem;
        }

        /* ปรับแต่ง footer ของ modal */
        .modal-footer {
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
        }

        /* ปรับแต่งปุ่มใน modal */
        .modal-footer .btn {
            margin-left: 0.5rem;
        }

        /* ปรับแต่งปุ่มกากบาท */
        .modal-header .close {
            padding: 0;
            margin: -3.5rem -1rem -0.5rem auto;
            /* ปรับค่า margin-top ให้สูงขึ้น */
            color: #000;
            opacity: 0.5;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 3rem;
            /* ปรับขนาดฟอนต์ให้ใหญ่พอสมควร */
        }

        .modal-title {
            font-size: 24px
        }

        @media screen and (max-width:550px) {
            .cart_total .payment {
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                gap: 10px;
                max-width: 250px;
                flex-wrap: wrap;
                align-self: center;
            }
        }
    </style>


@endsection

@section('profile_menu')
    <div class="profile_menu">
        <ul>
            <a href="{{ route('profile.edit') }}">
                <li>โปรไฟล์</li>
            </a>
            <a href="{{ route('profile.address') }}">
                <li>ที่อยู่</li>
            </a>
            <a href="{{ route('cart.show') }}">
                <li class="active">ตะกร้า</li>
            </a>
            <a href="{{ route('wishlist.show') }}">
                <li>พระที่ถูกใจ</li>
            </a>
            <a href="{{ route('profile.sell') }}">
                <li>ลงขายพระ</li>
            </a>
            <a href="{{ route('profile.payment') }}">
                <li>ช่องทางการชำระเงิน</li>
            </a>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; color: inherit; cursor: pointer; width:100%">ออกจากระบบ</button>
                </form>
            </li>
        </ul>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ฟังก์ชันคำนวณและอัพเดตราคา
        function updatePrices() {
            // ดึงข้อมูล input และ element ราคาทั้งหมด
            var qtyInputs = document.querySelectorAll('[id^="product-qty-"]');
            qtyInputs.forEach(input => {
                var productId = input.id.split('-').pop(); // ดึง id ของสินค้า
                var priceElement = document.getElementById('price-display-' + productId);
                var originalPrice = parseFloat(priceElement.getAttribute('data-original-price'));
                var qty = parseInt(input.value, 10);

                // ตรวจสอบว่าค่าของ qty เป็นหมายเลขที่ถูกต้อง
                if (!isNaN(qty) && qty > 0) {
                    var totalPrice = Math.round(originalPrice); // ปัดเศษราคาให้เป็นจำนวนเต็ม
                    priceElement.textContent = (totalPrice * qty) + ' บาท'; // แสดงราคา
                } else {
                    // ถ้า qty ไม่ถูกต้อง ให้แสดงราคาเริ่มต้น
                    priceElement.textContent = Math.round(originalPrice) + ' บาท'; // แสดงราคาเดิม
                }
            });
        }

        // เพิ่ม attribute data-original-price ให้กับ element price display
        var priceElements = document.querySelectorAll('[id^="price-display-"]');
        priceElements.forEach(priceElement => {
            var price = parseFloat(priceElement.textContent.replace(' baht', ''));
            priceElement.setAttribute('data-original-price', price);
        });

        // เพิ่ม event listener ให้กับ input แต่ละตัว เพื่ออัพเดตราคาเมื่อมีการเปลี่ยนแปลง
        var qtyInputs = document.querySelectorAll('[id^="product-qty-"]');
        qtyInputs.forEach(input => {
            input.addEventListener('input', updatePrices);
        });

        // เรียกใช้ฟังก์ชัน updatePrices เมื่อโหลดหน้า
        updatePrices();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let deleteProductId = null;
        let isDeleteModalOpen = false; // Flag เพื่อเช็คว่าโมดัลการลบเปิดอยู่หรือไม่

        // เมื่อคลิกปุ่มลบในแต่ละสินค้า
        document.querySelectorAll('.remove-product').forEach(button => {
            button.addEventListener('click', function() {
                deleteProductId = this.getAttribute('data-product-id');
                isDeleteModalOpen = true; // ตั้งค่า flag เมื่อโมดัลการลบเปิดขึ้น
                $('#confirmDeleteModal').modal('show'); // แสดงโมดัล
            });
        });

        // เมื่อคลิกปุ่มยืนยันลบในโมดัล
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (deleteProductId) {
                // เรียกใช้งานลบสินค้า
                fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: deleteProductId,
                            user_id: '{{ auth()->user()->id }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Product removed from cart successfully.') {
                            document.querySelector('.cart[data-product-id="' + deleteProductId +
                                '"]').remove();
                            $('#confirmDeleteModal').modal('hide'); // ซ่อนโมดัลหลังจากลบสำเร็จ
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบสินค้าออกจากตะกร้าได้',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    });
            }
        });

        // ปรับปรุงการคลิกของ chatRedirectButton
        document.getElementById('chatRedirectButton').addEventListener('click', function(event) {
            if (isDeleteModalOpen) {
                event.stopImmediatePropagation(); // หยุดการคลิกหากโมดัลการลบเปิดอยู่
                return; // ไม่ทำงานการส่งข้อมูลชำระเงิน
            }
            buyNow(qty, totalPrice, altText, sellId, username, productName, productImage,
                productQuantity, productUrl);
        });

        // การจัดการการเปลี่ยนแปลงของปริมาณสินค้า
        document.querySelectorAll('.product-qty').forEach(input => {
            input.addEventListener('input', function() {
                let min = parseInt(this.getAttribute('min'));
                let max = parseInt(this.getAttribute('max'));
                let value = parseInt(this.value);

                if (value < min) {
                    this.value = min;
                } else if (value > max) {
                    this.value = max;
                }

                // ส่งข้อมูลการอัพเดตไปยังเซิร์ฟเวอร์
                let productId = this.closest('.cart').getAttribute('data-product-id');
                let userId = '{{ auth()->user()->id }}';
                let qty = this.value;

                fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            product_id: productId,
                            product_qty: qty
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Cart updated successfully') {
                            console.log('Cart updated');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถอัพเดทจำนวนสินค้าได้',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    });
            });
        });
    });
</script>


<script>
    const LoginAuth = {{ auth()->check() ? auth()->user()->id : 0 }};
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("paymentModal");
        const paymentOptions = modal.querySelector(".payment-options");
        const cancelPaymentButton = document.getElementById("cancelPayment");
        const chatButtons = document.querySelectorAll(".buy_now");

        chatButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const sellId = this.getAttribute('data-sell-id'); // ดึง sellId จากปุ่ม
                const username = this.getAttribute('data-username'); // ดึง username จากปุ่ม
                const productName = this.getAttribute('data-product-name'); // ชื่อสินค้า
                const productImage = this.getAttribute(
                    'data-product-image'); // Path ของรูปภาพหรือวิดีโอ
                const productQuantity = this.getAttribute(
                    'data-product-quantity'); // จำนวนสินค้า
                const productUrl = this.getAttribute('data-product-url'); // ดึง URL ของสินค้า

                console.log("sell id: ", sellId);
                console.log("sell username: ", username);

                paymentOptions.innerHTML = ""; // ล้างตัวเลือกก่อน

                const cart = this.closest(".cart");
                const productId = cart.dataset.productId;

                // ดึงช่องทางการชำระเงินจากสินค้า
                const availablePayments = cart.querySelectorAll(".payment img");

                availablePayments.forEach((payment) => {
                    const paymentSrc = payment.src;
                    const altText = payment.alt;

                    const button = document.createElement("button");
                    button.innerHTML = `
                <img src="${paymentSrc}" alt="${altText}">
                <span>${altText}</span>`;

                    button.addEventListener("click", function() {
                        const qtyInput = cart.querySelector(".product-qty");
                        const qty = parseInt(qtyInput.value) || 1;
                        const priceDisplay = cart.querySelector(
                            ".cart_price p");
                        const productPrice = parseFloat(priceDisplay
                            .textContent) || 0;
                        const totalPrice = (productPrice).toFixed(2);

                        if (altText === "ธนาคาร" || altText === "QR code" ||
                            altText === "ทรูวอเล็ท") {
                            fetch(`/get-payment-info?sellId=${productId}`)
                                .then((response) => response.json())
                                .then((data) => {
                                    if (altText === "ธนาคาร") {
                                        paymentOptions.innerHTML = `
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <p><strong>ช่องทาง: ${altText}</strong></p>
                                        <p><strong>ธนาคาร:</strong> ${data.bank_name}</p>
                                        <p><strong>เลขบัญชี:</strong> ${data.account_number}</p>
                                        <p><strong>ชื่อบัญชี:</strong> ${data.account_name}</p>
                                        <p><strong>จำนวนสินค้า:</strong> ${qty}</p>
                                        <p><strong>ราคารวม:</strong> ${totalPrice} บาท</p>
                                        <button id="chatRedirectButton">ส่งหลักฐานการจ่ายเงิน</button>
                                    </div>`;
                                    } else if (altText === "QR code") {
                                        paymentOptions.innerHTML = `
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <p><strong>ช่องทาง: ${altText}</strong></p>
                                        <img src="/storage/${data.qr_image}" alt="QR Code">
                                        <p><strong>จำนวนสินค้า:</strong> ${qty}</p>
                                        <p><strong>ราคารวม:</strong> ${totalPrice} บาท</p>
                                        <button id="chatRedirectButton">ส่งหลักฐานการจ่ายเงิน</button>
                                    </div>`;
                                    } else if (altText === "ทรูวอเล็ท") {
                                        paymentOptions.innerHTML = `
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <p><strong>ช่องทาง: ${altText}</strong></p>
                                        <p><strong>เบอร์ TrueWallet:</strong> ${data.truewallet_phone}</p>
                                        <p><strong>จำนวนสินค้า:</strong> ${qty}</p>
                                        <p><strong>ราคารวม:</strong> ${totalPrice} บาท</p>
                                        <button id="chatRedirectButton">ส่งหลักฐานการจ่ายเงิน</button>
                                    </div>`;
                                    }

                                    const chatRedirectButton = document
                                        .getElementById(
                                            "chatRedirectButton");
                                    chatRedirectButton.addEventListener(
                                        "click",
                                        function() {
                                            // ลบสินค้าจากตะกร้าเมื่อคลิก
                                            fetch('{{ route('cart.remove') }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON
                                                        .stringify({
                                                            product_id: productId,
                                                            user_id: '{{ auth()->user()->id }}'
                                                        })
                                                })
                                                .then(response =>
                                                    response.json())
                                                .then(data => {
                                                    if (data
                                                        .message ===
                                                        'Product removed from cart successfully.'
                                                    ) {
                                                        document
                                                            .querySelector(
                                                                '.cart[data-product-id="' +
                                                                productId +
                                                                '"]'
                                                            )
                                                            .remove();
                                                        $('#confirmDeleteModal')
                                                            .modal(
                                                                'hide'
                                                            ); // ซ่อนโมดัลหลังจากลบสำเร็จ
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'เกิดข้อผิดพลาด!',
                                                            text: 'ไม่สามารถลบสินค้าออกจากตะกร้าได้',
                                                            confirmButtonText: 'ตกลง'
                                                        });
                                                    }
                                                });

                                            // เรียกใช้ฟังก์ชัน buyNow
                                            buyNow(qty, totalPrice,
                                                altText, sellId,
                                                username,
                                                productName,
                                                productImage,
                                                productQuantity,
                                                productUrl);
                                        });
                                })
                                .catch((error) => {
                                    console.error(
                                        "Error fetching payment info:",
                                        error);
                                    paymentOptions.innerHTML =
                                        `<div>เกิดข้อผิดพลาดในการดึงข้อมูล</div>`;
                                });
                        } else if (altText === "จ่ายเงินปลายทาง") {
                            // ดึงข้อมูลที่อยู่ของผู้ใช้
                            fetch(`/get-user-address`)
                                .then(response => response.json())
                                .then(address => {
                                    paymentOptions.innerHTML = `
                <div style="display: flex; justify-content: center; align-items: center; height: 100%; flex-direction:column; ">
                    <p><strong>${altText}</strong></p>
                    <p><strong>จำนวนสินค้า:</strong> ${qty}</p>
                    <p><strong>ราคารวม:</strong> ${totalPrice} บาท</p>
                    <textarea id="province" placeholder="จังหวัด">${address.province || ""}</textarea>
                    <textarea id="district" placeholder="อำเภอ">${address.district || ""}</textarea>
                    <textarea id="subdistrict" placeholder="ตำบล">${address.subdistrict || ""}</textarea>
                    <textarea id="post_code" placeholder="รหัสไปรษณีย์">${address.post_code || ""}</textarea>
                    <textarea id="additional_details" placeholder="รายละเอียดเพิ่มเติม" style="height:60px;">${address.additional_details || ""}</textarea>
                    <button id="chatRedirectButton" style="display:flex; justify-content:center;">ส่งที่อยู่</button>
                </div>`;
                                    const chatRedirectButton = document
                                        .getElementById(
                                            "chatRedirectButton");
                                    chatRedirectButton.addEventListener(
                                        "click",
                                        function() {
                                            // ลบสินค้าจากตะกร้าเมื่อคลิก
                                            fetch('{{ route('cart.remove') }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON
                                                        .stringify({
                                                            product_id: productId,
                                                            user_id: '{{ auth()->user()->id }}'
                                                        })
                                                })
                                                .then(response =>
                                                    response.json())
                                                .then(data => {
                                                    if (data
                                                        .message ===
                                                        'Product removed from cart successfully.'
                                                    ) {
                                                        document
                                                            .querySelector(
                                                                '.cart[data-product-id="' +
                                                                productId +
                                                                '"]'
                                                            )
                                                            .remove();
                                                        $('#confirmDeleteModal')
                                                            .modal(
                                                                'hide'
                                                            ); // ซ่อนโมดัลหลังจากลบสำเร็จ
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'เกิดข้อผิดพลาด!',
                                                            text: 'ไม่สามารถลบสินค้าออกจากตะกร้าได้',
                                                            confirmButtonText: 'ตกลง'
                                                        });
                                                    }
                                                });

                                            // เรียกใช้ฟังก์ชัน buyNow
                                            buyNow(qty, totalPrice,
                                                altText, sellId,
                                                username,
                                                productName,
                                                productImage,
                                                productQuantity,
                                                productUrl);
                                        });
                                })
                                .catch(error => {
                                    console.error(
                                        'Error fetching user address:',
                                        error);
                                    paymentOptions.innerHTML =
                                        `<div>เกิดข้อผิดพลาดในการดึงข้อมูล</div>`;
                                });
                        } else if (altText === "นัดรับ") {
                            // ไม่ดึงข้อมูลจากเซิร์ฟเวอร์
                            paymentOptions.innerHTML = `
            <div style="display: flex; justify-content: center; align-items: center; height: 100%; flex-direction: column;">
                <p><strong>${altText}</strong></p>
                <p><strong>จำนวนสินค้า:</strong> ${qty}</p>
                <p><strong>ราคารวม:</strong> ${totalPrice} บาท</p>
                <textarea id="additional_details" placeholder="รายละเอียดเพิ่มเติม" style="height:80px;"></textarea>
                <button id="chatRedirectButton" style="display:flex; justify-content:center;">ส่งรายละเอียด</button>
            </div>`;
                            const chatRedirectButton = document
                                .getElementById(
                                    "chatRedirectButton");
                            chatRedirectButton.addEventListener(
                                "click",
                                function() {
                                    // ลบสินค้าจากตะกร้าเมื่อคลิก
                                    fetch('{{ route('cart.remove') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON
                                                .stringify({
                                                    product_id: productId,
                                                    user_id: '{{ auth()->user()->id }}'
                                                })
                                        })
                                        .then(response =>
                                            response.json())
                                        .then(data => {
                                            if (data
                                                .message ===
                                                'Product removed from cart successfully.'
                                            ) {
                                                document
                                                    .querySelector(
                                                        '.cart[data-product-id="' +
                                                        productId +
                                                        '"]'
                                                    )
                                                    .remove();
                                                $('#confirmDeleteModal')
                                                    .modal(
                                                        'hide'
                                                    ); // ซ่อนโมดัลหลังจากลบสำเร็จ
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'เกิดข้อผิดพลาด!',
                                                    text: 'ไม่สามารถลบสินค้าออกจากตะกร้าได้',
                                                    confirmButtonText: 'ตกลง'
                                                });
                                            }
                                        });

                                    // เรียกใช้ฟังก์ชัน buyNow
                                    buyNow(qty, totalPrice,
                                        altText, sellId,
                                        username,
                                        productName,
                                        productImage,
                                        productQuantity,
                                        productUrl);
                                });
                        } else {
                            paymentOptions.innerHTML = `
                        <div>
                            <p><strong>${altText}</strong></p>
                            <p><strong>จำนวนสินค้า:</strong> ${qty}</p>
                            <p><strong>ราคารวม:</strong> ${totalPrice} บาท</p>
                        </div>
                    `;
                        }
                    });

                    paymentOptions.appendChild(button);
                });

                modal.style.display = "block";
            });
        });

        // ปิด modal เมื่อกดปุ่ม "ยกเลิก"
        cancelPaymentButton.addEventListener("click", function() {
            modal.style.display = "none";
        });

        // ปิด modal เมื่อคลิกด้านนอก
        window.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        function buyNow(qty, totalPrice, altText, sellId, username, productName, productImage,
            productQuantity, productUrl) {

            if (LoginAuth === sellId) {
                Swal.fire({
                    title: "ข้อผิดพลาด!",
                    text: "คุณไม่สามารถซื้อสินค้าของตัวเองได้",
                    icon: "error",
                    confirmButtonText: "ตกลง"
                }); // แจ้งเตือนหากเป็นผู้ขาย
                return; // หยุดการทำงานของฟังก์ชัน
            }


            // ข้อมูลของสินค้า
            const productId = productName; // ใช้ชื่อสินค้าที่ส่งมาจาก data-attributes
            const productImagePath = productImage; // ใช้ path รูปภาพหรือวิดีโอที่ส่งมา
            const productNameText = productName; // ชื่อสินค้า
            const productPrice = totalPrice; // ราคา
            const productQuantityText = qty; // จำนวนสินค้า
            const currentUrl = productUrl;
            const recipient = sellId; // รหัสของผู้ขาย
            const paymentText = altText; // ข้อความของการชำระเงิน
            var loggedInUserId = parseInt('{{ auth()->check() ? auth()->user()->id : 0 }}',
                10); // รับค่าผู้ใช้ที่ล็อกอิน

            // ดำเนินการที่ต้องการ (เช่น ส่งข้อมูลไปยังเซิร์ฟเวอร์ หรือแสดง modal)
            console.log("Product Name:", productNameText);
            console.log("Product Image:", productImagePath);
            console.log("Product Quantity:", productQuantityText);
            console.log("Total Price:", productPrice);
            console.log("Recipient (Seller ID):", recipient);
            console.log("Logged In User ID:", loggedInUserId);
            console.log("Payment Method Text:", paymentText);


            const url =
                `/chat?sellId=${encodeURIComponent(sellId)}&seller_id=${encodeURIComponent(username)}&product_id=${encodeURIComponent(productId)}&image=${encodeURIComponent(productImagePath)}&name=${encodeURIComponent(productName)}&price=${encodeURIComponent(productPrice)}&quantity=${encodeURIComponent(productQuantity)}&current_url=${currentUrl}&payment=${encodeURIComponent(paymentText)}`;

            log('URL to redirect:', url); // แสดง URL ที่จะถูกเปลี่ยนเส้นทาง
            log('User ID:', username); // แสดง userId
            log('Product ID:', productId); // แสดง productId
            log('Product Image Path:', productImagePath); // แสดง path ของรูปภาพ
            log('Product Name:', productName); // แสดงชื่อสินค้า
            log('Product Price:', productPrice); // แสดงราคา
            log('Product Quantity:', productQuantity); // แสดงจำนวนสินค้า
            log('Current URL:', currentUrl); // แสดง URL ปัจจุบัน
            log('AltText:', paymentText);
            // เปลี่ยนเส้นทางไปยังหน้า chat พร้อมข้อมูลที่ส่ง
            window.location.href = url;


            if (productId && productImagePath && productName && productPrice && productQuantity && recipient) {
                sendChatMessage(productName, productImagePath, productPrice, productQuantity, currentUrl,
                    username, recipient, paymentText);
            } else {
                console.warn('Missing product information.');
            }

            // ฟังก์ชันเพื่อส่งข้อความ
            function sendChatMessage(productName, productImage, productPrice, productQuantity, currentUrl,
                sellerId,
                recipient, paymentText) {
                const message = ''; // สามารถกำหนดข้อความเริ่มต้น หรือปล่อยว่าง

                // ข้อมูลสินค้า
                const product = {
                    product_name: productName,
                    product_image: productImagePath,
                    product_price: parseFloat(productPrice), // แปลงเป็นตัวเลข
                    product_quantity: parseInt(productQuantity, 10), // แปลงเป็นจำนวนเต็ม
                    current_url: currentUrl,
                    product_id: productId, // ตรวจสอบให้แน่ใจว่าตัวแปร productId ถูกประกาศก่อนหน้านี้
                    seller_id: username,
                    payment: paymentText
                };

                // รับ CSRF token จาก meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                console.log('Displaying product Sent', product);
                console.log('sender: ', loggedInUserId);
                console.log('recipient: ', parseInt(recipient, 10));
                console.log('message: ', message);

                axios.post('/store-message', {
                        sender: parseInt('{{ auth()->check() ? auth()->user()->id : 0 }}',
                            10), // ผู้ส่ง (ที่ได้จาก auth)
                        recipient: parseInt(recipient, 10), // ผู้รับ (currentUserId)
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
                        // แสดงรายละเอียดข้อผิดพลาด
                        console.error('Error sending message:', error.message);
                        if (error.response) {
                            console.error('Response data:', error.response.data);
                            console.error('Response status:', error.response.status);
                            console.error('Response headers:', error.response.headers);
                        } else if (error.request) {
                            // ข้อผิดพลาดที่เกิดขึ้นในการส่งคำขอ แต่ไม่ได้รับการตอบกลับ
                            console.error('Request data:', error.request);
                        } else {
                            // ข้อผิดพลาดในการตั้งค่าคำขอ
                            console.error('Error', error.message);
                        }
                    });
            }

            function log(...args) {
                console.log(...args);
            }



        }
    });
</script>
