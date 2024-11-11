<?php
include_once 'header2.php';
error_reporting(0);

if (isset($_SESSION['user_id'])) {

    if (isset($_POST['book'])) {
        // Sanitize and validate each input field
        $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $contact_no = filter_var(trim($_POST['contact_no']), FILTER_SANITIZE_NUMBER_INT);
        $test_drive_model = filter_var(trim($_POST['car_model']), FILTER_SANITIZE_STRING);
        $preferred_date = filter_var(trim($_POST['preferred_date']), FILTER_SANITIZE_STRING);
        $preferred_time = filter_var(trim($_POST['preferred_time']), FILTER_SANITIZE_STRING);
        $user = $_SESSION['user_name'];

        // Server-side validation
        $errors = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }
        if (!preg_match('/^\d{10}$/', $contact_no)) {
            $errors[] = "Please enter a valid 10-digit phone number.";
        }
        if (!DateTime::createFromFormat('Y-m-d', $preferred_date)) {
            $errors[] = "Please select a valid date.";
        }

        // If no errors, process the form
        if (empty($errors)) {
            $reservation_query = mysqli_query($conn, "INSERT INTO `testdrive`(name, email, contact, testdrivemodel, preferreddate, preferredtime, user) VALUES ('$name', '$email','$contact_no','$test_drive_model','$preferred_date','$preferred_time','$user')") or die('Query failed.');
            if ($reservation_query) {
                echo "<script>alert('Your test drive request has been successfully submitted. Our dedicated Sales Advisor will be in touch.'); window.location.href = 'index.php';</script>";
            }
        } else {
            // Display errors if any
            foreach ($errors as $error) {
                echo "<p class='error-message'>$error</p>";
            }
        }
    }
} else {
    echo "<script>alert('Please login first.'); window.location.href = 'login.php';</script>";
}
?>


<style>
    h2 {
        text-decoration: none;
        font-family: Arial,
            sans-serif;
        line-height: 1.5;
        color: red;
        font-size: 20pt;
        font-weight: bold;
        text-transform: uppercase;
    }

    label {
        font-family: Arial,
            sans-serif;
        color: #231F20;
        font-weight: 600;
        font-size: 12pt;
    }

    .prebook-input {
        width: 100%;
        border: 1px solid #cccccc;
        border-radius: 10px;
        font-size: 0.9rem;
        display: block;
        padding: 0.375rem 0.75rem;
        text-transform: none;
        box-sizing: border-box;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        outline: none;


    }

    input[type=text]:focus {
        border: 1px solid red;
    }

    input[type=date]:focus {
        border: 1px solid red;
    }

    ::placeholder {
        text-transform: none;
    }

    .model-select {
        display: block;
        width: 100%;
        border: 1px solid #cccccc;
        border-radius: 10px;
        font-size: 0.9rem;
        display: block;
        padding: 0.375rem 0.75rem;
        text-transform: none;
        box-sizing: border-box;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        outline: none;
    }

    select:focus {
        border: 1px solid red;
    }

    .time-select {
        display: block;
        width: 100%;
        border: 1px solid #cccccc;
        border-radius: 10px;
        font-size: 0.9rem;
        display: block;
        padding: 0.375rem 0.75rem;
        text-transform: none;
        box-sizing: border-box;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        outline: none;
    }

    .tnc {
        font-size: 0.9rem;
    }

    .tnc-checkbox {
        position: absolute;
        margin-top: 0.19rem;
        margin-left: -1.5rem;
        width: 17px;
        height: 17px;
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

    .error-message {
        color: red;
    }

    select {
        height: 35.2px;
    }
</style>

<body>
    <section style="padding-top:100px;">
        <div class="container">
            <h2>let's get in touch test driving</h2>
            <p style="margin-bottom:0px;">Kindly fill in your details below. All fields are required</p>
            <p>Our Friendly Sales Advisor will be in touch after you have completed your booking.</p>
            <form method="post" action="" class="prebook" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col">
                        <label>Name <span style="color:red;">*</span></label>
                        <input type="text" class="prebook-input" placeholder="Eg. Chris John" autocapitalize="none"
                            autocapitalize="off" name="name" required>
                    </div>
                    <div class="col">
                        <label>Email <span style="color:red;">*</span></label>
                        <input type="email" class="prebook-input" placeholder="Eg. user@gmail.com" autocapitalize="none"
                            autocapitalize="off" name="email" required>
                    </div>
                </div>

                <div class="row" style="padding-top:17px;">
                    <div class="col">
                        <label>Contact Number <span style="color:red;">*</span></label>
                        <input type="text" class="prebook-input" placeholder="Eg. 1234567" name="contact_no"
                            id="phoneno" required>
                    </div>
                    <div class="col">
                        <label>Outlet <span style="color:red;">*</span></label>
                        <input type="text" class="prebook-input" value="Penang Honda" disabled>
                    </div>
                </div>

                <?php
                $select = mysqli_query($conn, "SELECT * FROM carinformation");
                ?>

                <div class="row" style="padding-top:17px;">
                    <div class="col">
                        <label>Car model <span style="color:red;">*</span></label>
                        <select id="carModel" class="model-select" name="car_model" required>
                            <?php while ($crow = mysqli_fetch_assoc($select)) { ?>
                                <option value="<?php echo $crow['model']; ?>">
                                    <?php echo $crow['model']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label>Preferred Communication Mode <span style="color:red;">*</span></label>
                        <select id="carModel" class="model-select" name="communication" required>
                            <option value="email" selected="">Email</option>
                            <option value="phonecall" selected="">Phone Call</option>
                            <option value="sms" selected="">SMS</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="padding-top:17px;">
                    <div class="col">
                        <label>Preferred Date <span style="color:red;">*</span><span style="color:#8c8c8c;">(Available
                                for One Week Before the Test Drive)</span></label>
                        <input type="date" class="prebook-input" name="preferred_date" min="yyyy-mm-dd" max="yyyy-mm-dd"
                            style="width: 100%;" required>
                    </div>
                    <div class="col">
                        <label>Preferred Time <span style="color:red;">*</span></label>
                        <select class="time-select" id="preferred_time" name="preferred_time" required>
                            <option value="09:00 AM">09:00 AM</option>
                            <option value="09:30 AM">09:30 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="10:30 AM">10:30 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="11:30 AM">11:30 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="12:30 PM">12:30 PM</option>
                            <option value="13:00 PM">13:00 PM</option>
                            <option value="13:30 PM">13:30 PM</option>
                            <option value="14:00 PM">14:00 PM</option>
                            <option value="14:30 PM">14:30 PM</option>
                            <option value="15:00 PM">15:00 PM</option>
                            <option value="15:30 PM">15:30 PM</option>
                            <option value="16:00 PM">16:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="padding-top:30px;">
                    <div class="col" style="padding-left:40px; padding-right:30px;">
                        <input class="tnc-checkbox" type="checkbox" value="1" id="checkbox1">
                        <p class="tnc">I have read and agree to the Personal Data Protection Notice as posted on
                            <u><span style="color:red; font-weight: bold;">Personal Data
                                    Protection ("PDP Notice")</span></u> and consent to Honda processing my personal
                            data in
                            accordance with the PDP Notice.
                        </p>
                    </div>
                    <div class="col" style="padding-left:40px; padding-right:30px;">
                        <input class="tnc-checkbox" type="checkbox" value="1" id="checkbox2">
                        <p class="tnc">I confirm that I am a valid holder of a full driving license, and by
                            participating in
                            a test
                            drive, I agree to adhere to the <span style="color:red; font-weight: bold;">Terms and
                                Conditions</span> set forth by UMW Toyota Motor Sdn. Bhd.</p>
                    </div>
                </div>
                <span id="error-message1" class="error-message" style="display: none;">Please agree to the terms and
                    conditions.</span>


                <!-- Add the reCAPTCHA widget -->
                <div class="g-recaptcha" style="padding:10px;" id="recaptcha"
                    data-sitekey="6LfoNYUoAAAAAEVq6skfbba6eTOuLL8eL18I6GRJ">
                </div>
                <div id="recaptcha-error" class="error-message" style="display: none;"></div>
                <br />
                <p class="text-center"><button type="submit" name="book" class="book" value="book"
                        style="display: inline-block;">Submit</button></p>


            </form>
        </div>
    </section>

    <br />
    <br />
    <br />
</body>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function validateForm() {
        var checkbox1 = document.getElementById('checkbox1');
        var checkbox2 = document.getElementById('checkbox2');
        var errorMessage1 = document.getElementById('error-message1');
        var errorDiv = document.getElementById('recaptcha-error');

        if (!checkbox1.checked || !checkbox2.checked) {
            errorMessage1.style.display = 'block';
            return false;
        } else {
            errorMessage1.style.display = 'none';
        }

        if (grecaptcha.getResponse() === "") {
            errorDiv.innerHTML = "Please complete the reCAPTCHA to prove you are not a robot.";
            errorDiv.style.display = 'block';
            return false;
        }

        var phonePattern = /^\d{10}$/;
        var phoneFormat = document.getElementById('phoneno').value;

        if (!phonePattern.test(phoneFormat)) {
            alert("Please enter a valid phone number.");
            return false;
        }

        return true;
    }

    // Adjust date picker for "Preferred Date"
    function formatDate(date) {
        var dd = date.getDate();
        var mm = date.getMonth() + 1;
        var yyyy = date.getFullYear();
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        return yyyy + '-' + mm + '-' + dd;
    }

    function setMinMaxDates() {
        var today = new Date();
        var nextMonth = new Date(today);
        today.setDate(today.getDate() + 7); // Set minDate to one week from today

        nextMonth.setMonth(today.getMonth() + 1); // Move to the same day next month for maxDate
        var minDate = formatDate(today);
        var maxDate = formatDate(nextMonth);

        document.querySelectorAll('input[name="preferred_date"]').forEach(function(field) {
            field.setAttribute('min', minDate);
            field.setAttribute('max', maxDate);
        });
    }

    setMinMaxDates();
</script>

<?php
include_once 'footer.php';
?>