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
                        <p id="price-display-{{ $product->id }}">{{ $product->price }} baht</p>
                    </div>
                    <div class="cart_qty">
                        <input class="product-qty" type="number" id="product-qty-{{ $product->id }}" name="product-qty" min="1"
                            max="{{ $product->quantity ?? 'null' }}"
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
                    <div class="payment_chat">
                        <button class="remove-product" data-product-id="{{ $product->id }}">ลบ</button>
                    </div>
                    <div class="payment_chat">
                        <button>แชท</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .expired {
            color: red;
            font-weight: bold;
        }

        /* Modal Background */
        .custom-modal {
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
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
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
        let deleteProductId = null;

        // เมื่อคลิกปุ่มลบในแต่ละสินค้า
        document.querySelectorAll('.remove-product').forEach(button => {
            button.addEventListener('click', function() {
                deleteProductId = this.getAttribute('data-product-id');
                $('#confirmDeleteModal').modal('show'); // แสดงโมดัล
            });
        });

        // เมื่อคลิกปุ่มยืนยันลบในโมดัล
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (deleteProductId) {
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
                            alert('Failed to remove product from cart.');
                        }
                    });
            }
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
                            alert('Failed to update product quantity.');
                        }
                    });
            });
        });
    });
</script>

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
                    var totalPrice = Math.round(originalPrice * qty); // ปัดเศษราคาให้เป็นจำนวนเต็ม
                    priceElement.textContent = totalPrice + ' baht'; // แสดงราคา
                } else {
                    // ถ้า qty ไม่ถูกต้อง ให้แสดงราคาเริ่มต้น
                    priceElement.textContent = Math.round(originalPrice) + ' baht'; // แสดงราคาเดิม
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





