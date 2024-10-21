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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="css/cart.css">

</head>
<body>
    <section id="header">
        <div class="logo">
            <h4 style="color: white; letter-spacing: 2px;">SADUAKPRA</h4>
        </div>
        <div>
            <ul id="navbar">
                <li><a href="index.php">หน้าหลัก</a></li>
                <li><a href="shop.php">ซื้อพระ</a></li>
                <li><a href="auction.php">ประมูลพระ</a></li>
                <li><a class="cart_profile" href="cart.php"><img src="Component Pic/Cart.png" width="30" height="30"></a></li>
                <li><a class="cart_profile" href="profile.php"><img src="Profile Pic/default.png" width="30" height="30"></a></li>
                <button id="navbarButton"><i class="fa fa-bars"></i></button>
            </ul>
        </div>
        <div id="navbar2">
            <div class="close_menu">
                <button id="closeMenuButton"><i class="fa fa-times"></i></button>
            </div>
            <div class="profile_mobile">
                <a class="cart_profile" href="profile.php"><img src="Profile Pic/default.png" width="80" height="80"></a>
            </div>
            <div class="box_menu">
                <a href="index.php"><button>หน้าหลัก</button></a>
            </div>
            <div class="box_menu">
                <a href="shop.php"><button>ซื้อพระ</button></a>
            </div>
            <div class="box_menu">
                <a href="auction.php"><button>ประมูลพระ</button></a>
            </div>
            <div class="box_menu">
                <a href="cart.php"><button>ตะกร้า</button></a>
            </div>
        </div>
        <div id="mobile_filter">
            <div class="close_menu">
                <button id="closeMenuButton_filter"><i class="fa fa-times"></i></button>
            </div>
            <div class="box">
                <form class="check" action="#">
                    <h4 for="checkbox">ชื่อพระ</h4>
                    <input type="checkbox" id="toggleCheckbox1_mobile" class="hidden-checkbox">
                    <label for="toggleCheckbox1_mobile">
                        <img src="Component Pic/arrow.png" id="checkboxImage1" onclick="toggleCheckbox()">
                    </label>
                </form>
                <div class="toggle" id="toggle-1_mobile">
                    <div class="search">
                        <img src="Component Pic/search.webp" alt="">
                        <input type="search" class="search_input" placeholder="ค้นหา......">
                    </div>
                    <div class="name_list">
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-1_mobile" class="check_input_amulet">
                            <label for="input_amulet-1_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-2_mobile" class="check_input_amulet">
                            <label for="input_amulet-2_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-3_mobile" class="check_input_amulet">
                            <label for="input_amulet-3_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-4_mobile" class="check_input_amulet">
                            <label for="input_amulet-4_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-5_mobile" class="check_input_amulet">
                            <label for="input_amulet-5_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-6_mobile" class="check_input_amulet">
                            <label for="input_amulet-6_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-7_mobile" class="check_input_amulet">
                            <label for="input_amulet-7_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-8_mobile" class="check_input_amulet">
                            <label for="input_amulet-8_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-9_mobile" class="check_input_amulet">
                            <label for="input_amulet-9_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_amulet-10_mobile" class="check_input_amulet">
                            <label for="input_amulet-10_mobile" class="checkbox"></label>
                            <span>พระเครื่อง</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <form class="check" action="#">
                    <h4 for="checkbox">จังหวัด</h4>
                    <input type="checkbox" id="toggleCheckbox2_mobile" class="hidden-checkbox">
                    <label for="toggleCheckbox2_mobile">
                        <img src="Component Pic/arrow.png" id="checkboxImage2_mobile" onclick="toggleCheckbox()">
                    </label>
                </form>
                <div class="toggle" id="toggle-2_mobile">
                    <div class="search">
                        <img src="Component Pic/search.webp" alt="">
                        <input type="search" class="search_input" placeholder="ค้นหา......">
                    </div>
                    <div class="name_list">
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-1_mobile" class="check_input_amulet">
                            <label for="input_province-1_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-2_mobile" class="check_input_amulet">
                            <label for="input_province-2_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-3_mobile" class="check_input_amulet">
                            <label for="input_province-3_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-4_mobile" class="check_input_amulet">
                            <label for="input_province-4_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-5_mobile" class="check_input_amulet">
                            <label for="input_province-5_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-6_mobile" class="check_input_amulet">
                            <label for="input_province-6_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-7_mobile" class="check_input_amulet">
                            <label for="input_province-7_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-8_mobile" class="check_input_amulet">
                            <label for="input_province-8_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-9_mobile" class="check_input_amulet">
                            <label for="input_province-9_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                        <div class="name_amulet">
                            <input type="checkbox" id="input_province-10_mobile" class="check_input_amulet">
                            <label for="input_province-10_mobile" class="checkbox"></label>
                            <span>จังหวัด</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <form class="check" action="#">
                    <h4 for="checkbox">ราคา</h4>
                    <input type="checkbox" id="toggleCheckbox3_mobile" class="hidden-checkbox">
                    <label for="toggleCheckbox3_mobile">
                        <img src="Component Pic/arrow.png" id="checkboxImage3_mobile" onclick="toggleCheckbox()">
                    </label>
                </form>
                <div class="toggle" id="toggle-3_mobile">
                    <div class="price_slider_wrapper">
                        <div class="price-input">
                            <div class="field">
                                <span>น้อยสุด</span>
                                <input type="number" name="" class="input-min" value="0" >
                            </div>
                            <!-- <div class="seperator">-</div> -->
                            <div class="field">
                                <span>มากสุด</span>
                                <input type="number" name="" class="input-max" value="10000000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <form class="check" action="#">
                    <h4 for="checkbox">เรียงตาม</h4>
                    <input type="checkbox" id="toggleCheckbox4_mobile" class="hidden-checkbox">
                    <label for="toggleCheckbox4_mobile">
                        <img src="Component Pic/arrow.png" id="checkboxImage4_mobile" >
                    </label>
                </form>
                <div class="toggle" id="toggle-4_mobile">
                    <div class="sort">
                        <button class="lowest">Low to High</button>
                    </div>
                    <div class="sort">
                        <button class="highest">High to Low</button>
                    </div>
                    <div class="sort">
                        <button class="newest">New</button>
                    </div>
                </div>
            </div>
        </div>
        
        </div>
    </section>

    <section class="container">
        <div class="grid">
            <div class="profile_content1">
                <div class="user_img">
                    <div class="profile_img">
                        <label class="-label" for="file">
                        <span class="glyphicon glyphicon-camera"></span>
                        <span>Change Image</span>
                        </label>
                        <input id="file" type="file" onchange="loadFile(event)"/>
                        <img src="Profile Pic/default.png" id="output" width="200" />
                    </div>
                    <h4>FirstName LastName</h4>
                    <img src="Component Pic/star.png" alt="">
                </div>
                <div class="profile_menu">
                    <ul>
                        <a href="profile.php"><li>โปรไฟล์</li></a>
                        <a href="address.php"><li>ที่อยู่</li></a>
                        <a href="cart.php"><li>ตะกร้า</li></a>
                        <a href="wish_list.php"><li>พระที่ถูกใจ</li></a>
                        <a href="sell.php"><li class="active">ลงขายพระ</li></a>
                        <a href=""><li>ออกจากระบบ</li></a>
                        
                    </ul>
                </div>
                
            </div>
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
                                <a href="add_item.php" class="hambar">
                                    <button class="edit" style="margin-top: 5px;">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </a>
                                
                                <button class="edit" id="delete"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>         
            </div>
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
            <p>PATTARADON  WONGCHAI</p>
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
    <script src="/js/script2.js"></script>
    <script src="https://kit.fontawesome.com/d671ca6a52.js" crossorigin="anonymous"></script>
    
</body>
</html>