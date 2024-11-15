<?php
include_once 'header2.php';
?>

<?php
if (isset($_SESSION['user_id'])) {
    $model = isset($_GET['model']) ? $_GET['model'] : die();
    $variant = isset($_GET['variant']) ? $_GET['variant'] : null;


    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }


    $sql = "SELECT * FROM carinformation WHERE model='$model'";

    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $modelpic = $row['modelpic'];
        }
    }
} else {
    echo "User ID is not set in the session.";
    echo "<script>alert('Please login first.'); window.location.href = 'login.php';</script>";
}
?>


<style>
    h2 {
        text-decoration: none;
        font-family: Arial,
            sans-serif;
        line-height: 1.5;
        color: black;
        font-size: 20pt;
        font-weight: 700;
        text-transform: uppercase;
    }

    .container .model {
        margin-bottom: 0px;
        color: #706f6f;
        font-size: 16pt;
        line-height: 1.5;
        font-weight: bold;
        padding-bottom: 10px;
        border-bottom: 2px solid black;
    }

    .container .variant {
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: bold;
        line-height: 1.5;
        letter-spacing: 1.0px;
        text-align: left;
        text-transform: uppercase;
        font-size: 1.5rem;
        border-bottom: 2px solid black;
    }

    .container .color {
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: bold;
        line-height: 1.5;
        letter-spacing: 1.0px;
        text-align: right;
        text-transform: uppercase;
        font-size: 1.5rem;
        border-bottom: 2px solid black;
    }

    .container .promotion {
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: bold;
        line-height: 1.5;
        letter-spacing: 1.0px;
        text-align: center;
        text-transform: uppercase;
        font-size: 1.5rem;
        border-bottom: 2px solid black;
    }

    .color-div .radio-item {
        text-align: right;
    }

    .promotion-div .radio-item {
        text-align: center;
    }



    /* hide the default radio button */
    .radio-item [type="radio"] {
        display: none;
    }

    .radio-item label {
        /* display: block; */
        padding: 15px 60px;
        border: 2px solid white;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        position: relative;
        transition: 0.4s ease-in-out 0s;
    }

    .radio-item label:after,
    .radio-item label:before {
        content: "";
        position: absolute;
        border-radius: 50%;
    }

    .radio-item label:after {
        height: 19px;
        width: 19px;
        left: 21px;
        border: 2px solid #706f6f;
        top: calc(50% - 12px);
    }

    .radio-item label:before {
        background: #706f6f;
        height: 19px;
        width: 19px;
        left: 21px;
        top: calc(50% - 12px);
        transform: scale(5);
        opacity: 0;
        visibility: hidden;
        transition: 0.4s ease-in-out 0s;
    }

    .radio-item [type="radio"]:checked~label {
        border-color: #706f6f;
    }

    .radio-item [type="radio"]:checked~label::before {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .book {
        font-size: 1rem;
        font-weight: 400;
        border-radius: 4px;
        padding: 10px 480px;
        border: 1px solid red;
        background: red;
        color: #fff;
        transition: transform 0.5s ease;
    }

    .book:hover {
        border: 1px solid red;
        background: #b1351f;
    }

    input[type="submit"] {
        font-size: 1rem;
        font-weight: 400;
        border-radius: 4px;
        padding: 10px 100px;
        margin-top: 30px;
        border: 1px solid red;
        background: red;
        color: #fff;
        transition: transform 0.5s ease;
        display: block;
        margin: 0 auto;
        text-align: center;
        margin-bottom: 40px;
    }

    input[type="submit"]:hover {
        border: 1px solid red;
        background: #b1351f;
    }
</style>

<body>
    <!-- Show name and image -->
    <section style="padding-top:100px;">
        <div class="container">
            <?php
            echo '
            <h2 class>book your honda</h2>
            <p class="model">' . $model . '</p>
            <img src="img/' . $modelpic . '" class="car-model" alt="Honda Accord"
                style="margin: 0 auto; display:block; margin-top:30px;" width="522px" height="219px" />
                ';
            ?>
        </div>
    </section>

    <!-- Select variant and color -->
    <?php
    $select = mysqli_query($conn, "SELECT * FROM specifications WHERE Model = '$model'");
    ?>
    <section>
        <form action="prebookcolor.php" method="POST">
            <div class="container">
                <h3 class="variant">Variants</h3>
                <input name="model" type="hidden" value="<?php echo $model; ?>">
                <?php while ($crow = mysqli_fetch_assoc($select)) { ?>
                    <div class="radio-item">
                        <input name="variant" id="radio<?php echo $crow['Id']; ?>" type="radio"
                            value="<?php echo $crow['ModelType']; ?>" required>
                        <label for="radio<?php echo $crow['Id']; ?>">
                            <?php echo $crow['ModelType']; ?>
                        </label>
                    </div>
                <?php } ?>

            </div>

            <input type="submit" name="submit" value="Next">


        </form>
    </section>
</body>

<?php
include_once 'footer.php';
?>