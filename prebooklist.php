

<?php

include 'adminSidebar.php';


?>


<html>



<body onload="sidebarHeight()">
    <div style="margin-left:250px;">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search data.." style="margin: 40px 0 0 30px; padding:7px; width: 700px;">
        <p style="color:#7f8788; margin-left:40px; margin-top:15px;">* Tick the checkbox and click the button to delete the prebooking<br/>* Clicking the button indicates that the car has been sold, and the stock has been updated. Purchase Summary will send to customer via email.</br>* If the current car is out of stock, the prebooking will be deleted automatically, and the user will be notified by email.</p>
        <h2 style="text-align: center;">Prebook Records</h1>
        <div class="frame" style="width: 90%; margin-top: 40px;">
        <form action="prebookBuyCancel.php" method="POST">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Payment method</th>
                        <th>Price(RM)</th>
                        <th>Account</th>
                        <th>Date</th>
                        <th>Cancel</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $prebook = mysqli_query($conn, "SELECT * FROM `prebook`");

                    $counter = 1;
                    if (mysqli_num_rows($prebook) > 0) {
                        while ($fetch_reservation = mysqli_fetch_assoc($prebook)) {
                            ?>
                            <tr>
                                <td style="font-size:16px;">
                                    <?php echo $counter; ?>.
                                    <input type="hidden" id="id" name="id<?php echo $counter; ?>"
                                        value="<?php echo $fetch_reservation['id']; ?>">
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="name" name="name<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['name']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;width:100px;">
                                    <input type="text" id="email" name="email<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['email']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="contact" name="contact<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['contact']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="model" name="model<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['model']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="color" name="color<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['color']); ?>" style="text-align:center;"
                                        readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="paymentmethod" name="paymentmethod<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['paymentmethod']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="bookingfee" name="price<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['price']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="account" name="account<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['account']); ?>" readonly>
                                </td>
                                <td style="font-size:16px;">
                                    <input type="text" id="date" name="date<?php echo $counter; ?>"
                                        value="<?php echo ($fetch_reservation['date']); ?>" readonly>
                                </td>

                                <td style="font-size:16px;">
                                    <input type="checkbox" id="cancel" name="cancel<?php echo $counter; ?>" value="1">

                                </td>

                                <td class="text">
                                    <p class="center-text"><button type="submit" name="book<?php echo $counter; ?>"
                                            class="btn-confirm" style="display: inline-block; margin-top: 20px;">Confirm</button>
                                    </p>
                                </td>
                            </tr>
                            <?php
                            $counter++;


                        }
                        ;
                    }
                    ;
                    ?>

                </tbody>
            </table>
        </form>
        </div>
    </div>
    <!-- </section> -->
</body>

<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, i, j, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Start looping from the second row (index 1)
        for (i = 1; i < tr.length; i++) {
            // Loop through all input fields in the row
            var found = false;
            var inputFields = tr[i].getElementsByTagName("input");
            for (j = 0; j < inputFields.length; j++) {
                if (inputFields[j]) {
                    txtValue = inputFields[j].value;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Break out of the loop if a match is found
                    }
                }
            }
            // Show or hide the row based on whether a match was found in any input field
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>

</html>