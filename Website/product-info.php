<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--change title-->
        <title>Product Information</title>
        <link rel="stylesheet" href="header-styles.css">
        <link rel="stylesheet" href="customer-styles.css"><!--change css file-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
        <script src="app.js" defer></script>
        <!-- add the code below to load the icons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <header>
            <div class="header-container">
                <div class="website-title">
                    <img id="logo" src="images/client-logo.jpg">
                    <div class="text">
                        <h1>Fat Rap's Barbeque's Online Store</h1>
                    </div>
                </div>
                <nav>
                    <ul>
                        <!--TODO: ADD LINKS-->
                        <li><a href="cus-home-page.php">Home</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Cart</a></li>
                        <!-- Text below should change to 'Logout'once user logged in-->
                        <?php
                        if (isset($_SESSION['prsn_id'])) {
                        ?>
                            <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                            <li>
                            <?php
                        } else {
                            ?>
                            <li><a href="<?php echo SITEURL; ?>login-page.php">Login</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <section class="section product-info-page">
                <div class="section-heading"></div> 
                <a href="" class="back">Back</a>
                <section class="block">
                   <img src="https://myfoodbook.com.au/sites/default/files/styles/1x1/public/recipe_photo/Chicken_Pineapple_Summer_Skewers_web.jpg" alt="">
                    <div class="right-grp">
                         <div class="top">
                            <h1>Pork BBQ</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictum.</p>
                        </div>
                       <div class="bottom">
                            <div class="inline">
                                <h1>₱25.00</h1>
                                <div class="quantity-grp">
                                    <i class='bx bxs-minus-circle js-minus'></i>
                                    <p class="amount js-num">1</p>
                                    <i class='bx bxs-plus-circle js-plus'></i>
                                </div>
                                <p class="remaining">200 sticks available</p>
                            </div>
                            <button>Add to Cart</button> 
                        </div>
                    </div>
                </section>
            </section>
        </main>
        <footer>
            <div class="footer-container">
                <div class="left-container">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                    <div class="list">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Menu</a></li>
                            <li><a href="#">Cart</a></li>
                            <li><a href="#">Track order</a></li>
                        </ul>
                    </div>
                </div>
                <div class="right-container">
                    <div class="icons-block">
                        <img id="logo" src="images/circle logo.png">
                        <img id="logo" src="images/circle logo.png">
                        <img id="logo" src="images/circle logo.png">
                    </div>
                    <div class="list">
                        <div class="list-items">
                            <!--insert icon-->
                            <p>email@gmail.com</p>
                        </div>
                        <div class="list-items">
                            <!--insert icon-->
                            <p>0912 345 6789 | 912 1199</p>
                        </div>
                        <div class="list-items">
                            <!--insert icon-->
                            <p>123 Magaling St., Brgy. Something, Somewhere City</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script> /*js code for the increment and decrement buttons for the quantity*/
            const plus = document.querySelector(".js-plus"),
                minus = document.querySelector(".js-minus"),
                num = document.querySelector(".js-num");

            let a = 1;

            plus.addEventListener("click", ()=>{
                a++;
                console.log(a);
                num.innerText = a;
            } 
            );

            minus.addEventListener("click", ()=>{
                if(a > 1) {
                    a--;
                    console.log(a);
                    num.innerText = a;
                }
            } 
            );
        </script>
    </body>
</html>