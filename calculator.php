<?php
include_once 'header2.php';
include "functions.php";
$spec = getAllSpec();
?>

<?php

$model = mysqli_query($conn, "SELECT * FROM carinformation");

?>



<style>
    h4 {

        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: 500;
        line-height: 1.5;
        letter-spacing: 2px;
        font-size: 1.125rem;
        text-transform: uppercase;
        padding-bottom: 30px;
    }

    h5 {

        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: 500;
        line-height: 1.5;
        letter-spacing: 1.5px;
        font-size: 0.900rem;
        text-transform: uppercase;
        color: grey;
    }

    .select-title {
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-weight: 500;
        line-height: 1.5;
        letter-spacing: 1.5px;
        font-size: 0.8rem;
        text-transform: uppercase;
        padding-bottom: 10px;
        color: #999999;
    }

    .calculator-li {
        padding-bottom: 30px;
        list-style: none;
        margin: 0;
    }

    .calculator-select {
        padding: 20px;
        width: 80%;
    }

    .downpayment {
        position: relative;
    }

    .downpayment-input {
        width: 80%;
        padding: 20px;
        padding-left: 50px;
        display: block;
    }

    .rm {
        position: absolute;
        top: 22px;
        margin-left: 21px;
    }


    .calculated-result {
        padding-bottom: 20px;
    }

    .calculated-result h5 {
        color: black;
    }

    .total-result {
        padding-bottom: 10px;
        padding-left: 30px;
        "

    }

    .total-result h5 {
        font-size: 1.0rem;
        color: red;
        font-weight: 600;
        line-height: 1.5;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .total-result-title {
        padding-top: 30px;
        border-top: 2px solid red;
        margin-top: 20px;
    }
</style>

<section style="padding-top:100px;padding-bottom:80px; background-color:#eeeeee">
    <h3>LOAN CALCULATOR</h2>
        <p class="text-center">Estimate your monthly budget by using the tools below.</p>
        <div class="container">
            <div class="row">
                <div class="col" style="padding:10px;">
                    <h4>1. car details</h4>
                    <div class="loan-details">
                        <ul class="calculator-form">
                            <li class="calculator-li">
                                <div class="select-title">model</div>
                                <div class="dropdown-calculator">
                                    <form id="" name="" method="POST">
                                    <select id="carModel" class="calculator-select" name="carModel">
                                                <option value="">All</option>
                                        <?php while ($row = mysqli_fetch_assoc($model)) { ?>
                                                <option value="<?php echo $row['model']; ?>">
                                                <?php echo $row['model']; ?>
                                                </option>
                                        <?php } ?>
                                    </select>
                                            <div class="category" style="display:none;">
                                                <h2>All Spec</h2>
                                            </div>
                                    </form>
                                </div>
                            </li>
                            <li class="calculator-li">
                                <div class="select-title">variant</div>
                                <div class="dropdown-calculator">
                                    <select id="modelSpec" name="modelSpec" class="calculator-select">
                                        <?php
                                            
                                            foreach ($spec as $specs){
                                                ?>
                                                <option value="<?php echo $specs['Price']?>"><?php echo $specs['ModelType']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" style="padding:10px;">
                    <h4>2. loan details</h4>
                    <div class="loan-details">
                        <ul class="calculator-form">
                            <li class="calculator-li">
                                <div class="select-title">down payment</div>
                                <div class="downpayment">
                                    <input id="downpayment-amt" type="text" name="downpayment"
                                        class="downpayment-input">
                                    <span class="rm">RM</span>
                                </div>
                            </li>
                            <li class="calculator-li">
                                <div class="select-title">interest rate(%)</div>
                                <div class="downpayment">
                                    <input id="interest-rate" type="number" name="downpayment" class="downpayment-input"
                                        style="padding-left:20px;" value="3" min="0">
                                    <span class="rm"></span>
                                </div>
                            </li>
                            <li class="calculator-li">
                                <div class="select-title">duration</div>
                                <div class="dropdown-calculator">
                                    <select id="cars" class="calculator-select">
                                        <option value="9">9</option>
                                        <option value="8">8</option>
                                        <option value="7">7</option>
                                        <option value="6">6</option>
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" style="background-color: white;">
                    <div class="result" style="background-color:white; padding:30px;">
                        <div class="title-result" style="">
                            <h5>estimated retail price without insurance</h5>
                        </div>
                        <div class="calculated-result" style="">
                            <h5>RM---</h5>
                        </div>
                        <div class="title-result" style="">
                            <h5>down payment</h5>
                        </div>
                        <div class="calculated-result" style="">
                            <h5>RM---</h5>
                        </div>
                        <div class="title-result" style="">
                            <h5>loan required</h5>
                        </div>
                        <div class="calculated-result" style="">
                            <h5>RM---</h5>
                        </div>
                        <div class="total-result-title text-center">
                            <h5>estimated monthly price</h5>
                        </div>
                        <div class="total-result">
                            <h5>RM ---/month</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>

    let selectMenu = document.querySelector("#carModel");
    let category = document.querySelector(".category h2")
    let container = document.querySelector(".modelSpec")

    selectMenu.addEventListener("change", function(){
        let categoryName = this.value;
        category.innerHTML = this[this.selectedIndex].text;

        let http = new XMLHttpRequest();

        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                let response = JSON.parse(this.responseText);
                let out = "";
                for(let item of response){
                    out += `<option value="${item.Price}">${item.ModelType}</option>`;
                }
                // Update the select element's options, not container.innerHTML
                document.querySelector("#modelSpec").innerHTML = out;
                updateCalculations();
            }
            
        }

        http.open('POST',"script.php",true);
        http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        http.send("category="+categoryName);

    });

    let selectModelSpec = document.querySelector("#modelSpec");
    let downpaymentAmt = document.getElementById("downpayment-amt");
    let interestRate = document.getElementById("interest-rate");
    let duration = document.getElementById("cars");
    let estimatedRetailPrice = document.querySelector(".calculated-result h5");
    let downPaymentResult = document.querySelectorAll(".calculated-result h5")[1];
    let loanRequiredResult = document.querySelectorAll(".calculated-result h5")[2];
    let estimatedMonthlyPrice = document.querySelector(".total-result h5");


    // Attach an event listener to the select element
    selectModelSpec.addEventListener("change", function() {
        // Get the selected option's value
        let selectedValue = this.value;

        // Update the downpayment-amt input's value
        downpaymentAmt.value = selectedValue/10;
        updateCalculations();
    });

    downpaymentAmt.addEventListener("input", function() {
        updateCalculations();
    });

    interestRate.addEventListener("input", function() {
        updateCalculations();
    });

    duration.addEventListener("change", function() {
        updateCalculations();
    });

    function updateCalculations() {
        let selectedValue = parseFloat(selectModelSpec.value);
        estimatedRetailPrice.textContent = `RM ${selectedValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;
        let downPayment = parseFloat(downpaymentAmt.value);
        let loanRequired = selectedValue - downPayment;
        downPaymentResult.textContent = `RM ${downPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;
        loanRequiredResult.textContent = `RM ${loanRequired.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;
        let interest = parseFloat(interestRate.value) / 100;
        let numberOfMonths = parseInt(duration.value) * 12;
        let monthlyInterestRate = interest / 12;
        let estimatedMonthly = loanRequired * (monthlyInterestRate * Math.pow(1 + monthlyInterestRate, numberOfMonths)) / (Math.pow(1 + monthlyInterestRate, numberOfMonths) - 1);
        estimatedMonthlyPrice.textContent = `RM ${estimatedMonthly.toFixed(2)}/month`;
    }

</script>


<?php
include_once 'footer.php';
?>