<?php
include('config/constants.php');

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Power of Dreams | Honda Malaysia</title>
    <script src="https://kit.fontawesome.com/1527c486de.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img/honda-icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="//code.tidio.co/qied5pfxufauymib8y3r8j4wc8ksprqo.js" async></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-transform: capitalize;
            text-decoration: none;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            /* font-family: Arial, sans-serif; */
            /* margin: 0px; */
        }

        h3 {
            text-align: center;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-weight: 300;
            line-height: 1.5;
            letter-spacing: 2.0px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: whitesmoke;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
            padding: 0px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
        }

        header .navbar2 ul {
            list-style: none;
        }

        header .navbar2 ul li {
            position: relative;
            float: left;
        }

        header .navbar2 ul li a {
            font-size: 20px;
            padding: 20px;
            color: #333;
            display: block;
        }

        header .navbar2 ul li a:hover {
            /* background: #333; */
            color: red;
            text-decoration: none;
        }

        header .navbar2 ul li ul {
            position: absolute;
            left: 0;
            width: 200px;
            background: #eeeeee;
            display: none;
        }

        header .navbar2 ul li ul li {
            width: 100%;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        header .navbar2 ul li:hover>ul {
            display: initial;
        }

        footer {
            background-color: black;
            padding: 70px;
            justify-content: space-between;
            color: #5a5c6f !important;
            margin-top: -1.5px;

        }

        .text-center {
            text-align: center !important;
        }
    </style>

<body>

    <header>



        <!-- <div class="logo"> -->
        <a href="index.php">
            <img class="toplogo" src="https://www.honda.com.my/img/interface/honda-logo-pod2.svg"
                alt="Honda - The Power of Dreams">
        </a>
        <!-- </div> -->


        <?php
        $select = mysqli_query($conn, "SELECT * FROM carinformation");
        ?>

        <nav class="navbar2">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Models<i class="fa fa-sort-desc" style="margin-left: 6px;"></i></a>
                    <ul>
                        <?php while ($crow = mysqli_fetch_assoc($select)) { ?>
                            <li><a href="carInformation.php?model=<?php echo $crow['model']; ?>">
                                    <?php echo $crow['model']; ?>
                                </a></li>
                        <?php } ?>
                    </ul>
                </li>

                <li><a href="testdrivebooking.php">Test Drive</a></li>
                <li><a href="accessory.php">Accessory</a></li>
                    
                        <?php

                        if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'supplier') {
                            echo '<li><a href="add_accessory.php">Add Accessories (Supplier)</a></li>';
                        }
                        if (isset($_SESSION['user_name'])) {
                            echo ' 
                                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
                                        <ul>
                                            <li>
                                                <a href="account.php">User Profile</a>
                                                <a href="config/logout.php">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="config/logout.php" title="Login now!"><i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
                                ';
                        } else {
                            echo ' 
                                        <li>
                                            <a href="login.php">Login</a>
                                        </li>
                                    ';
                        }

                        ?>
            </ul>

        </nav>

    </header>


    <script>
        // JavaScript function to toggle the search bar
        function toggleSearch() {
            var searchIcon = document.querySelector('.search-icon');
            searchIcon.classList.toggle('active');
        }
    </script>
</body>

</html>