<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Fat Rap's Barbeque's Online Store</title>
        <!-- <link rel="stylesheet" href="header-styles.css"> -->
        <link rel="stylesheet" href="home-styles.css"><!--change css file-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="home.js" defer></script>
    </head>
    <body>
        <header></header>
        <main>
            <!-- section 1 -->
            <section class="section" id="featured-section">
                <div class="container responsive">
                    <div class="text">
                        <h1>Order our best-selling BBQ</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                        <button class="button">Order Now</button>
                    </div>
                    <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="picture of a pork bbq">
                </div>
            </section>
            <!-- section 2 -->
            <section class="section" id="calendar-section">
                <div class="container responsive">
                    <div class="text">
                        <h1>See our available dates</h1>
                        <div class="legend">
                            <button class="button available-tag">Available</button>
                            <button class="button fully-booked-tag">Fully Booked</button>
                            <button class="button closed-tag">Closed</button>
                        </div>
                    </div>
                    <section class="calendar-block"> <!-- reference code: https://www.youtube.com/watch?v=OcncrLyddAs-->
                        <div class="header">
                            <button id="prevBtn">
                                <i class='bx bx-chevron-left'></i>
                            </button>
                            <div class="monthYear" id="monthYear"></div>
                            <button id="nextBtn">
                                <i class='bx bx-chevron-right'></i>
                            </button>
                        </div>
                        <div class="days">
                            <div class="day">Mon</div>
                            <div class="day">Tue</div>
                            <div class="day">Wed</div>
                            <div class="day">Thur</div>
                            <div class="day">Fri</div>
                            <div class="day">Sat</div>
                            <div class="day">Sun</div>
                        </div>
                        <div class="dates" id="dates"></div>
                    </section>
                </div>
            </section>
            <!-- section 3 -->
            <section class="section" id="product-section">
                <div class="container responsive">
                    <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="picture of a pork bbq">
                    <div class="text">
                        <h1>Product Name</h1>
                        <p>P25.00</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                        <div class="action-grp responsive">
                            <button class="button">Order Now</button>
                            <div class="with-remaining">
                                <div class="quantity-group">
                                    <i class='bx bxs-minus-circle js-minus circle' data-stock="<?php echo $FOOD_STOCK; ?>"></i>
                                    <p class="amount js-num">1</p>
                                    <i class='bx bxs-plus-circle js-plus circle' data-stock="<?php echo $FOOD_STOCK; ?>"></i>
                                </div>
                                <p class="remaining">10 sticks remaining</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section 4 -->
            <section class="section" id="track-order-section">
                <div class="container responsive">
                    <div class="text">
                        <h1>Want to track your order?</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                    </div>
                    <form action="" class="form">
                        <div class="top input-control">
                            <h2>Order Number</h2>
                            <hr>
                            <input name="track-order" type="text" id="number" placeholder="0123456789">
                            <div class="error"></div>
                        </div>
                        <button name="submit" id="track-order" type="submit" class="button">Track Order</button>
                    </form>
                </div>
                </div>
            </section>
            <!-- section 5 -->
            <section class="section" id="wholesale-section">
                <div class="container responsive">
                    <div class="text">
                        <h1>Looking for wholesale deals?</h1>
                        <button class="button">Sign up as a Wholesale Customer</button>
                    </div>
                </div>
            </section>
        </main>
        <footer></footer>
    </body>
</html>