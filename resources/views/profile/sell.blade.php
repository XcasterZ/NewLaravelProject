@extends('profile_layout')
@section('title', 'profile')
@section('content2')
    <div class="profile_content2">
        {{-- <h4 style="text-align: left;">Seller Name</h4> --}}
        @foreach ($products as $product)
            <div class="cart" data-product-id="{{ $product->id }}"
                data-end-time="{{ $product->date }} {{ $product->time }}">
                <div class="cart_product">
                    <div class="cart_img">
                        @if ($product->file_path_1)
                            @php
                                $fileExtension = pathinfo($product->file_path_1, PATHINFO_EXTENSION);
                                
                                // Define route based on conditions
                                $route = null;
                                if (!is_null($product->quantity) && is_null($product->date) && is_null($product->time)) {
                                    $route = route('product.showshop', ['id' => $product->id]);
                                } elseif (!is_null($product->date) && !is_null($product->time) && is_null($product->quantity)) {
                                    $route = route('auction.show', ['id' => $product->id]);
                                }
                            @endphp
                    
                            @if ($route)
                                <a href="{{ $route }}" target="_blank">
                                    @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                        <video width="320" height="240" autoplay muted loop>
                                            <source src="{{ asset('storage/' . $product->file_path_1) }}" type="video/{{ $fileExtension }}">
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
                        <div class="sale_or_auction">
                            @if (!is_null($product->quantity) && $product->quantity > 0)
                                <span>ขาย</span>
                            @elseif (!is_null($product->time) && !is_null($product->date))
                                <span class="auction-status">
                                    ประมูล <br>
                                    <span class="countdown-timer"></span>
                                    <span class="expired" style="display: none;"> (หมดเวลา)</span>
                                </span>
                            @endif
                        </div>
                        <div class="cart_price">
                            <p>{{ $product->price }} baht</p>
                        </div>
                        <div class="wish">
                            <a href="{{ route('products.edit', $product->id) }}" class="hambar">
                                <button class="edit" style="margin-top: 0px;">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </a>
                            <form id="deleteForm_{{ $product->id }}"
                                action="{{ route('products.destroy', $product->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="edit deleteButton" data-product-id="{{ $product->id }}"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="save_edit">
            <button onclick="window.location.href='{{ route('profile.add_item') }}'">เพิ่มสินค้า</button>
        </div>
    </div>

    <!-- Modal -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.deleteButton');
            var confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {});
            var confirmDeleteButton = document.getElementById('confirmDeleteButton');
            var deleteForm = null;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    var productId = button.getAttribute('data-product-id');
                    deleteForm = document.getElementById('deleteForm_' + productId);
                    confirmDeleteModal.show();
                });
            });

            confirmDeleteButton.addEventListener('click', function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });

            function updateCountdown(cart) {
                var now = new Date().getTime();
                var endTimeStr = cart.getAttribute('data-end-time');
                var endTime = new Date(endTimeStr).getTime();

                if (isNaN(endTime)) {
                    console.error('Invalid end time format:', endTimeStr);
                    return;
                }

                var distance = endTime - now;
                var countdownElement = cart.querySelector('.countdown-timer');
                var expiredElement = cart.querySelector('.expired');

                if (distance < 0) {
                    countdownElement.style.display = 'none';
                    expiredElement.style.display = 'inline';
                } else {
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownElement.innerHTML = days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s ";
                }
            }

            function startCountdowns() {
                document.querySelectorAll('.cart').forEach(function(cart) {
                    setInterval(function() {
                        updateCountdown(cart);
                    }, 1000);
                    updateCountdown(cart); // initial call to display countdown immediately
                });
            }

            startCountdowns();
        });
    </script>

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
                <li>ตะกร้า</li>
            </a>
            <a href="{{ route('wishlist.show') }}">
                <li>พระที่ถูกใจ</li>
            </a>
            <a href="{{ route('profile.sell') }}">
                <li class="active">ลงขายพระ</li>
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
