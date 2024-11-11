
<?php

include 'adminSidebar.php';


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM testdrive WHERE id = $id");
    echo "<script>alert('Test drive deleted')</script>";

}
?>

<html>

<body onload="sidebarHeight()">
    <div style="margin-left:250px;">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search data.."
        style="margin: 40px 0 0 30px; padding:7px; width: 700px;">
        <p style="color:#7f8788; margin-left:40px; margin-top:15px;">*Please leave a message for the customer if you
            wish to change the date or
            time.<br />*If yes, please ask them to make a new request.</p>
            <h2 style="text-align: center;">Test Drive Records</h1>
            <div class="frame" style="width: 90%; margin-top: 40px;">
                <form action="email.php" method="POST">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Model</th>
                                <th>Preferred Date</th>
                                <th>Preferred Time</th>
                                <th>Account</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $select_reservation = mysqli_query($conn, "SELECT * FROM `testdrive`");
                            $counter = 1;
                            if (mysqli_num_rows($select_reservation) > 0) {
                                while ($fetch_reservation = mysqli_fetch_assoc($select_reservation)) {
                                    $checkInDate = date("Y-m-d", strtotime($fetch_reservation['preferreddate'])); // Extracts the date portion (YYYY-MM-DD) from the check-in datetime string
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
                                            <input type="text" id="testdrivemodel" name="testdrivemodel<?php echo $counter; ?>"
                                                value="<?php echo ($fetch_reservation['testdrivemodel']); ?>" readonly>
                                        </td>
                                        <td class="" style="font-size:16px;">
                                            <input type="text" id="preferred_date" name="preferred_date<?php echo $counter; ?>"
                                                value="<?php echo $checkInDate; ?>" readonly>
                                        </td>
                                        <td style="font-size:16px;">
                                            <input type="text" id="preferred_time" name="preferred_time<?php echo $counter; ?>"
                                                value="<?php echo ($fetch_reservation['preferredtime']); ?>" readonly>
                                        </td>
                                        <td style="font-size:16px;">
                                            <input type="text" id="user" name="user<?php echo $counter; ?>"
                                                value="<?php echo ($fetch_reservation['user']); ?>" readonly>
                                        </td>
                                        <td style="font-size:16px;">
                                            <textarea id="note" name="note<?php echo $counter; ?>" placeholder="note" row="15"
                                                style="width: 250px;height: 100px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
                                        </td>
                                        <td class="text">
                                            <p class="center-text"><button type="submit" name="send<?php echo $counter; ?>"
                                                    class="btn-edit"
                                                    style="display: inline-block; margin-top: 20px;">Send</button>
                                            </p>
                                            <a href="testdrivelist.php?delete=<?php echo $fetch_reservation['id']; ?>"
                                                class="btn-delete">Delete </a>
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