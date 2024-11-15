<?php
include_once 'header2.php';

// Check if user role is banned
if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'banned') {
    echo "<script>alert('You are banned from making a booking.'); window.location.href = 'index.php';</script>";
    exit; // Stop further execution of the script
}

$variant = filter_input(INPUT_POST, 'variant', FILTER_SANITIZE_STRING);
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
$model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);

if ($variant) {
    $stmt = $conn->prepare("SELECT Price FROM specifications WHERE ModelType = ?");
    $stmt->bind_param("s", $variant);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $price = $row['Price'];
    } else {
        echo "<p class='error-message'>Error: Model specification not found.</p>";
        $price = 'N/A'; // Default if no price is found
    }
    $stmt->close();
}

if (isset($_POST['book'])) {
    $name_form = filter_input(INPUT_POST, 'form_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $contact_no = filter_input(INPUT_POST, 'contact_no', FILTER_SANITIZE_NUMBER_INT);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
    $variant = filter_input(INPUT_POST, 'variant', FILTER_SANITIZE_STRING);
    $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $date = date('Y-m-d');

    if ($email && preg_match("/^\d{10}$/", $contact_no)) {
        $stmt = $conn->prepare("INSERT INTO prebook (name, email, contact, paymentmethod, model, color, price, account, date, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssdsis", $name_form, $email, $contact_no, $payment_method, $variant, $color, $price, $name, $date, $user_id);
        if ($stmt->execute()) {
            echo "<script>alert('Prebook done'); window.location.href = 'index.php';</script>";
        } else {
            echo "<p class='error-message'>Error: Unable to complete the booking. Please try again later.</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='error-message'>Please provide valid email and contact number.</p>";
    }
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

    .input-payment {
        border-top: 0px;
        border-left: 0px;
        border-right: 0px;
        width: 100%;
        padding: 0.375rem 0.75rem;
    }

    .payment-form {
        padding-bottom: 30px;
    }

    .book {
        font-size: 1rem;
        font-weight: 400;
        border-radius: 4px;
        padding: 10px 100px;
        margin-top: 30px;
        border: 1px solid red;
        background: red;
        color: #fff;
        transition: transform 0.5s ease;
    }

    .book:hover {
        border: 1px solid red;
        background: #b1351f;
    }

    .summary_table tr:first-child {
        border-bottom: 1px solid #000;
    }

    .summary_table th,
    .summary_table td {
        padding: 10px;

    }

    .tnc-checkbox {
        position: absolute;
        margin-top: 0.19rem;
        margin-left: -1.5rem;
        width: 17px;
        height: 17px;
    }

    .error-message {
        color: red;
    }

    .promoLabel{
        margin-top: 30px;
        color: red;
        font-weight: bold;
        font-size: 20px;
    }

    .promo {
        padding: 5px;
        font-size: 16px;
        border-radius: 5px;
        border: 3px solid #000;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 10px;
        text-align: center;
    }

    .btn-promo{
        display: block;
        width: 160px;
        height:50px;
        cursor: pointer;
        border-radius: 0.5rem;
        margin-top: 10px !important;
        margin: 0 auto;
        font-size: 20px;
        padding: 10px;
        background-color: white; 
        color: black; 
        border: 2px solid red;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
    }

    .btn-promo:hover{
        background-color: red;
        color: white;
        transform: translateY(-2px);
    }
</style>

<body>
    <section style="padding-top:100px;padding-bottom:10px;">
        <div class="container">
            <h2>book your honda</h2>
            <p style="margin-bottom:0px;">Kindly fill in your details below. All fields are required</p>
            <p>Our Friendly Sales Advisor will be in touch after you have completed your booking.</p>
        </div>

        <form method="post" onsubmit="return validateForm()">
            <div class="container" style="margin-top:60px; width:100%;">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="payment-form" style="display:block;">
                            <label style="display:block;">Name <span style="color:red;">*</span></label>
                            <input type="text" class="input-payment" name="form_name" id="" value="" required>
                        </div>
                        <div class="payment-form" style="display:block;">
                            <label style="display:block;">Email <span style="color:red;">*</span></label>
                            <input type="email" class="input-payment" name="email" id="" value="" required>
                        </div>
                        <div class="payment-form" style="display:block;">
                            <label style="display:block;">Contact Number <span style="color:red;">*</span></label>
                            <input type="text" class="input-payment" name="contact_no" id="phoneno" value="" required>
                        </div>
                        <div class="payment-form" style="display:block;">
                            <label style="display:block;">Outlet <span style="color:red;">*</span></label>
                            <input type="text" class="input-payment" name="" id="" value="Penang Honda" disabled>
                        </div>
                        <div class="payment-form" style="display:block;">
                            <label>Choose a payment method <span style="color:red;">*</span></label><br />
                            <div class="payment">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="radio" id="html" name="payment_method" value="Credit or Debit"
                                            required>
                                        <label for="creditordebit">Credit / Debit</label><br>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" id="css" name="payment_method" value="Online banking"
                                            required>
                                        <label for="css">Online Banking</label><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img alt="Credit Card" src="img/visa.png" width="100" height="35">
                                    </div>
                                    <div class="col-md-4">
                                        <img alt="FPX (Online Banking)" src="img/fpx.png" width="100" height="35">

                                    </div>
                                </div>
                                <div style="margin-top:20px;">
                                    <input class="tnc-checkbox" type="checkbox" value="1" id="checkbox1">
                                    <p class="tnc">I have read the term and agree to the website's <span
                                            style="color:red; font-weight: bold;">Terms and Conditions.</span>
                                    </p>
                                    <span id="error-message1" class="error-message" style="display: none;">Please agree
                                        to the terms and
                                        conditions.</span>
                                </div>
                                <p class="text-center"><button type="submit" name="book" class="book" value="book"
                                        style="display: inline-block;">Book</button></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="summary">
                            <table class="summary_table" style="width:100%;">
                                <tr>
                                    <th>Model</th>
                                    <td>
                                        <?php echo "$model"; ?>
                                    </td>
                                </tr>
                                <tr style="background:#f2f2f2;">
                                    <th>Variant</th>
                                    <th>
                                        <?php echo "$variant"; ?>
                                        <input name="variant" type="hidden" value="<?php echo $variant; ?>">
                                        <input name="user_name" type="hidden"
                                            value="<?php echo $_SESSION['user_name']; ?>">
                                        <input name="user_id" type="hidden" value="<?php echo $_SESSION['user_id']; ?>">
                                    </th>
                                </tr>
                                <tr class="">
                                    <td class="">
                                        Car Price
                                    </td>

                                    <td>
                                        <span class=""></span><div id="display_price">RM
                                        <?php echo "$price"; ?></div></span>
                                        <input name="price" id="price" type="hidden" value="<?php echo $price; ?>">
                                    </td>
                                </tr>
                                <tr style="background:#f2f2f2;">
                                    <td class="">
                                        Colour
                                    </td>

                                    <td class="">
                                        <span class=""></span>
                                        <?php echo "$color"; ?></span>
                                        <input name="color" type="hidden" value="<?php echo $color; ?>">
                                    </td>
                                </tr>
                                <tr style="background:#f2f2f2;">

                                    <th class="">
                                        Online Booking Fee
                                    </th>

                                    <th class="">
                                        <span class="">RM</span>100.00</span>
                                    </th>
                                </tr>

                                <tr style="background:#f2f2f2; display:none">

                                <th class="">
                                    Discount Amount
                                </th>

                                <th class="">
                                    <span class="">RM</span><span><div id="discountAmount">0.00</div></span>
                                </th>
                            </tr>
                            </table>
                            <label for="promoCode" class="promoLabel">Apply promotion code:</label>                
                            <input type="text" id="promoCode" name="promoCode" class="promo" placeholder="Promotion Code">
                            <button id="apply" class="btn-promo">Apply</button>
                            <br>
                            <b><span id="promo-message" style="color:green;"></span></b>          
                            <b><span id="promo-error-message" style="color:red;"></span></b>      
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="prebookform.js"></script>
<script>
    function validateForm() {
        var checkbox1 = document.getElementById('checkbox1');
        var errorMessage1 = document.getElementById('error-message1');

        if (!checkbox1.checked) {
            errorMessage1.style.display = 'block';
            return false;
        } else {
            errorMessage1.style.display = 'none';

            var phonePattern = /^\d{10}$/;
            var phoneFormat = document.getElementById('phoneno').value;

            if (!phonePattern.test(phoneFormat)) {
                alert("Please enter a valid phone number.");
                return false;
            }
            return true;
        }
    }

    $("#apply").click(function(e) {
        e.preventDefault();
        var promoCode = $('#promoCode').val().trim();
        if (promoCode) {
            $.ajax({
                type: "POST",
                url: "checkPromo.php",
                data: { coupon_code: promoCode },
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.statusCode == 200) {
                        var after_apply = parseFloat($('#price').val()) - dataResult.value;
                        $('#price').val(after_apply);
                        document.getElementById('display_price').textContent = 'RM ' + after_apply.toFixed(2);
                        $('#apply').hide();
                        $('#promo-message').html("Promocode applied successfully!");
                    } else if (dataResult.statusCode == 201) {
                        $('#promo-error-message').html("Invalid promotion code!");
                    }
                }
            });
        } else {
            $('#promo-error-message').html("Promotion code cannot be blank. Please enter a valid code!");
        }
    });
</script>

<?php include_once 'footer.php'; ?>