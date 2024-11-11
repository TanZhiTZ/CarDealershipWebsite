<?php
    include_once 'adminSidebar.php';
?>
<html>
    <body onload="sidebarHeight()">
        <div style="padding: 1px; margin-left: 250px;">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for customer name" style="margin: 40px 0 0 30px; padding:7px; width: 700px;">
            <div class="frame" style="width: 90%; margin-top: 40px;">
                <div class="row">
                    <div class="col">
                        Customer Name
                    </div>
                    <div class="col">
                        Email
                    </div>
                    <div class="col">
                        Model Type
                    </div>
                    <div class="col">
                        Price (RM)
                    </div>
                    <div class="col">
                        Date
                    </div>
                </div>
                <hr/><br/>
                <table id="myTable" class="admin" style="width: 100%;">

                <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'honda');

                    $sql = "SELECT * FROM history ORDER BY date DESC"; 

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    if($count>0) {
                        while($row=mysqli_fetch_assoc($res)) {
                            $name = $row['name'];
                            $email = $row['email'];
                            $contact = $row['contact'];
                            $model = $row['model'];
                            $color = $row['color'];
                            $paymentmethod = $row['paymentmethod'];
                            $price = $row['price'];
                            $date = $row['date'];

                        echo '
                            <tr class="row row-shader">
                                <td class="col" style="margin: auto;">
                                    <p style="margin-bottom: 0;">'.$name.'</p>
                                </td>
                                <td class="col">
                                    <p style="margin-bottom: 0; font-weight:500; margin: auto;">'.$email.'</p>
                                </td>
                                <td class="col">
                                    <p style="margin-bottom: 0; font-weight:500; margin: auto;">'.$model.'</p>
                                </td>
                                <td class="col" style="margin: auto;">
                                    <p id="price" class="admin" style="letter-spacing: 2px; margin-bottom: 0; font-weight:500;">'.number_format((float)$price, '2', '.', ',').'</p>
                                </td>
                                <td class="col" style="margin: auto;">
                                    <p style="margin-bottom: 0;">'.$date.'</p>
                                </td>
                            </tr>';
                        }
                    }
                ?>
                </table>
            </div>
        </div>
    </body>
</html>