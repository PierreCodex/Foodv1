<?php
include('clientPartials/clientHeader.php');


if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit();
}
?>
<!-- Home Section -->
 
<?php
if (isset($_SESSION['OrderAdded'])) {
    echo $_SESSION['OrderAdded'];
    unset($_SESSION['OrderAdded']);
}
?>

<?php
/*
if (isset($_SESSION['TableReserved'])) {
    echo $_SESSION['TableReserved'];
    unset($_SESSION['TableReserved']);
}*/
?>

<!--  Aquí mostramos el mensaje de error que viene de la sesión-->
<?php
if (isset($_SESSION['orderError'])) {
    echo $_SESSION['orderError'];
    unset($_SESSION['orderError']);
}
?>



<section id="home" class="home container">

    <div class="sectionContent grid">
        <div data-aos="fade-right" class="homeText">
            <h1 class="title">
                Disfruta <span>del mejor ceviche</span><br> directo a tu mesa
            </h1>

            <p>
                Ordena fácil y rápido tus platos favoritos de mariscos frescos sin salir de casa.
            </p>

            <button class="btn flex">
                ¡Haz tu pedido ahora! <i class="uil uil-arrow-right icon"></i>
            </button>
        </div>

        <div class="homeImage">
            <img src="./Assests/new (20).png" alt="Delicious ceviche and seafood">
        </div>

        <img src="./Assests/floating (1).png" alt="" class="floatingImg1">
        <img src="./Assests/floating (2).png" alt="" class="floatingImg2">
        <img src="./Assests/floating (3).png" alt="" class="floatingImg3">
    </div>

</section>

<!-- Home Section Ends -->


<!-- Category Section -->
<div class="categoriesDiv container">
    <div class="sectionContent grid">

        <!-- Single Category -->
        <div data-aos="fade-right" data-aos-duration="2000" class="singleCat">
            <img src="./Assests/diet.png" alt="Food Website">

            <h2 class="catTitle">
                Tasty Foods
            </h2>

            <p>
                There are so many varieties of food around the town but ours got one more taste.
            </p>

            <a class="btn" href="menu.php">
                See Menu
            </a>

        </div>

        <!-- Single Category -->
        <div data-aos="fade-right" data-aos-duration="3000" class="singleCat">
            <img src="./Assests/drink.png" alt="Food Website">

            <h2 class="catTitle">
                Drinks
            </h2>

            <p>
                There are so many varieties of food around the town but ours got one more taste.
            </p>

            <a class="btn" href="menu.php">
                See Menu
            </a>

        </div>

        <!-- Single Category -->
        <div data-aos="fade-right" data-aos-duration="4000" class="singleCat">
            <img src="./Assests/cake.png" alt="Food Website">

            <h2 class="catTitle">
                Cakes
            </h2>

            <p>
                There are so many varieties of food around the town but ours got one more taste.
            </p>

            <a class="btn" href="menu.php">
                See Menu
            </a>

        </div>

        <!-- Single Category -->
        <div data-aos="fade-right" data-aos-duration="5000" class="singleCat">
            <img src="./Assests/dessert.png" alt="Food Website">

            <h2 class="catTitle">
                Dessert
            </h2>

            <p>
                There are so many varieties of food around the town but ours got one more taste.
            </p>

            <a class="btn" href="menu.php">
                See Menu
            </a>

        </div>

    </div>
</div>
<!-- Category Section ends -->

<!-- About Section -->
<section id="about" class="about section container">

    <div class="sectionContent grid">
        <div class="aboutImage">
            <img src="./Assests/aboutImage.png" alt="Online food Image">
        </div>
        <div data-aos="fade-left" data-aos-duration="2000" class="aboutText">
            <h1 class="title">
                Why People Choose Us!
            </h1>

            <div class="aboutList grid">
                <div data-aos="fade-down" data-aos-duration="2000" class="singleInfo flex">

                    <div class="smallImage">
                        <img src="./Assests/hamburger.png" alt="Food delivery">
                    </div>

                    <div class="desc">
                        <h5>Choose Your Favourite</h5>
                        <p>
                            There are so many varieties of food around the town but ours got one more taste.
                        </p>

                    </div>


                </div>
                <div data-aos="fade-down" data-aos-duration="3000" class="singleInfo flex">

                    <div class="smallImage">
                        <img src="./Assests/delivery-man.png" alt="Food delivery">
                    </div>

                    <div class="desc">
                        <h5>We Deliver Your Meals</h5>
                        <p>
                            There are so many varieties of food around the town but ours got one more taste.
                        </p>

                    </div>


                </div>

                <div data-aos="fade-down" data-aos-duration="4000" class="singleInfo flex">

                    <div class="smallImage">
                        <img src="./Assests/dish.png" alt="Food delivery">
                    </div>

                    <div class="desc">
                        <h5>Grab Your Delicious</h5>
                        <p>
                            There are so many varieties of food around the town but ours got one more taste.
                        </p>

                    </div>


                </div>
            </div>


        </div>
    </div>

</section>
<!-- About Section Ends -->

<!-- Popular Food Items -->
<section class="section popular container">
    <div class="sectionContent">
        <div data-aos="fade-down" data-aos-duration="4000" class="sectionIntro">
            <h2>Our Popular Food Item</h2>
            <p>You don't need a silver fork to eat good food.</p>
        </div>

        <div class="contentWrapper">
            <div class="content swiper">
                <div class="swiper-wrapper">
                    <?php
                    $sql = "SELECT * FROM food order by RAND() LIMIT 0,6 ";
                    $res = mysqli_query($conn, $sql);
                    if ($res == TRUE) {
                        $count = mysqli_num_rows($res);
                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $img = $row['image'];
                                $foodName = $row['food_name'];
                                $foodDesc = $row['food_desc'];
                                $foodPrice = $row['price'];
                                $category = $row['category'];

                    ?>

                                <div class="swiper-slide singleItem">
                                    <div class="rating">
                                        <i class='bx bxs-star icon'></i>
                                        4.5
                                    </div>
                                    <?php
                                    if ($img != "") {
                                    ?>
                                        <div class="imgDiv flex">
                                            <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>">
                                                <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                            </a>
                                        </div>
                                    <?php

                                    } else {
                                        echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                    }
                                    ?>
                                    <h2 class="foodTitle">
                                        <?php echo $foodName ?>
                                    </h2>

                                    <p>
                                        <?php echo $foodDesc ?>
                                    </p>

                                    <h4 class="priceDiv flex">
                                        <span class="price">$<?php echo $foodPrice ?> </span>
                                        <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>">
                                            <span class="detailsLink"> Details <i class="uil uil-external-link-alt "></i></span>
                                        </a>
                                    </h4>
                                </div>

                    <?php

                            }
                        } else {
                            echo '<span class="blank">No local food in the database yet, please add!</span>';
                        }
                    }
                    ?>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
<!-- Popular Food Items Ends -->

<!-- Customer Feedback -->
<section class="section container review">
    <div class="sectionContent grid">
        <div class="secText">

            <div data-aos="fade-down" data-aos-duration="2000" class="secTitle">
                <h2>Customer <span>Feedback</span></h2>
            </div>

            <div class="content">
                <div data-aos="fade-down" data-aos-duration="3000" class="singleCustomer">
                    <p>
                        This cozy restaurant has left the best impressions! Hospitable hosts, delicious dishes, beautiful presentation, wide wine list and wonderful dessert. I recommend to everyone! I would like to come back here again and again.
                    </p>

                    <div class="customerDetails flex">
                        <div class="img">
                            <img src="./Assests/user (1).jpg" alt="Online food ordering">
                        </div>
                        <div class="name">
                            <small>IsraTech</small> <br>
                            <span>
                                Web Developer
                            </span>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-right" data-aos-duration="2000" class="records flex">
                    <div data-aos="fade-up" data-aos-duration="2000" class="leftDiv flex">
                        <img src="./Assests/chef (2).png" alt="Online restaurant">
                        <h1>50</h1>
                        <span>Chef <br> Professionals</span>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="3000" class="leftDiv flex">
                        <img src="./Assests/medal.png" alt="Online restaurant">
                        <h1>140</h1>
                        <span>Customer <br> Satisfaction</span>
                    </div>

                </div>
            </div>

        </div>

        <div class="secImage">
            <img src="./Assests/chef.png" alt="Food chef" data-aos="fade-left" data-aos-duration="2000">
        </div>
    </div>
</section>
<!-- Customer Feedback Ends-->

<!-- Subscription Section -->
<section class="section container newsLetter">
    <div data-aos="fade-right" data-aos-duration="2000" class="sectionContent flex">
        <h1>Subscribe <span>Newsletter</span></h1>

        <form method="POST">
            <div class="input flex">
                <input type="email" name="email" placeholder="Enter your email address">
                <input type="hidden" name="date" value="<?php echo date("Y-m-d") ?>">

                <button name="submit" class="btn">
                    Subscribe Now
                </button>

            </div>
        </form>
    </div>
</section>
<!-- Subscription Section End -->

<?php
include('clientPartials/clientFooter.php');
?>


<?php

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $date = $_POST['date'];

    $sql = "INSERT INTO subscribers SET
  email = '$email',
  date = '$date'
  ";

    $result = mysqli_query($conn, $sql);

    if ($result == TRUE) {
        $_SESSION['subscribed'] = '<span class="success">Administrator Added Successfully!</span>';
        header('location:' . SITEURL);
        exit();
    } else {

        die('Failed to connect to database!');
    }
}
?>