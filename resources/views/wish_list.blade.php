@extends('profile_layout')
@section('title', 'profile')
@section('content2')
    <div class="profile_content2">
        <div class="cart">
            <h4>Seller Name</h4>
            <div class="cart_product">
                <div class="cart_img">
                    <img src="Item/rec01.webp" alt="">
                </div>
                <div class="grid_cart">
                    <div class="cart_name">
                        <p>dasdadasdsadsadsadssdadsdasdsa</p>
                    </div>
                    <div class="cart_price">
                        <p>25000 baht</p>
                    </div>
                    <div class="wish">
                        <button class="addWish"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
            <div class="cart_product">
                <div class="cart_img">
                    <img src="Item/rec01.webp" alt="">
                </div>
                <div class="grid_cart">
                    <div class="cart_name">
                        <p>dasdadasdsadsadsadssdadsdasdsa</p>
                    </div>
                    <div class="cart_price">
                        <p>25000 baht</p>
                    </div>
                    <div class="wish">
                        <button class="addWish"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
            <div class="cart_product">
                <div class="cart_img">
                    <img src="Item/rec01.webp" alt="">
                </div>
                <div class="grid_cart">
                    <div class="cart_name">
                        <p>dasdadasdsadsadsadssdadsdasdsadasdadasdsadsadsadssdadsdasdsadasdadasdsadsadsadssdadsdasdsadasdadasdsadsadsadssdadsdasdsa
                        </p>
                    </div>
                    <div class="cart_price">
                        <p>25000 baht</p>
                    </div>
                    <div class="wish">
                        <button class="addWish"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('profile_menu')
    <div class="profile_menu">
        <ul>
            <a href="profile.php">
                <li>โปรไฟล์</li>
            </a>
            <a href="address.php">
                <li>ที่อยู่</li>
            </a>
            <a href="cart.php">
                <li>ตะกร้า</li>
            </a>
            <a href="wish_list.php">
                <li class="active">พระที่ถูกใจ</li>
            </a>
            <a href="sell.php">
                <li>ลงขายพระ</li>
            </a>
            <a href="">
                <li>ออกจากระบบ</li>
            </a>

        </ul>
    </div>
@endsection
