<?php
    include_once 'adminSidebar.php';
?>
<html>
    <body onload="sidebarHeight()">
        <div style="padding: 1px; margin-left: 250px;">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for models.." style="margin: 40px 0 0 30px; padding:7px; width: 700px;">
            <div class="frame" style="width: 90%; margin-top: 40px;">
                <div class="row">
                    <div class="col">
                        Model Type
                    </div>
                    <div class="col">
                        Picture
                    </div>
                    <div class="col">
                        Price (RM)
                    </div>
                    <div class="col">
                        Editing
                    </div>
                </div>
                <hr/><br/>
                <table id="myTable" style="width: 100%;">

                <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'honda');

                    $sql = "SELECT * FROM specifications INNER JOIN carinformation ON specifications.Model = carinformation.model ORDER BY ModelId"; 

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    if($count>0) {
                        while($row=mysqli_fetch_assoc($res)) {
                            $model = $row['Model'];
                            $modelType = $row['ModelType'];
                            $price = $row['Price'];
                            $imgmodel = $row['model'];
                            $img = $row['modelpic'];
                            $nm = "'".$modelType."'";

                        echo '
                            <tr class="row row-shader" style="margin-top: 20px;">
                                <td class="col" style="margin: auto;">
                                    <h4  id="model" type="model" name="model" style="color:red;">'.$modelType.'</h4>
                                </td>
                                <td class="col" style="margin-top:17px; margin-bottom:17px;">
                                    <img src="img/'.$imgmodel.'/'.$img.'" width="130px"/>
                                </td>
                                <td class="col" style="margin: auto;">
                                    <p id="price" style="letter-spacing: 2px;">'.number_format((float)$price, '2', '.', ',').'</p>
                                </td>
                                <td class="col" style="margin: auto;">
                                    <button onclick="editPrice('.$nm.')">edit</button>
                                </td>
                            </tr>';
                        }
                    }
                ?>
                </table>
            </div>
        </div>
        <script>
            function editPrice(model) {
                let isValid = false;
                let np;

                while (!isValid) {
                    np = prompt("Enter the new price (numbers only):");

                    // Check if the input is a valid number (positive decimal or integer)
                    if (np !== null && np.trim() !== "" && !isNaN(np) && parseFloat(np) >= 0 || confirm('Are you sure you want to cancel?')) {
                        isValid = true;
                    } else if (isValid = false){
                        alert("Please enter a valid numeric value.");
                    }
                }

                if (isValid && np != null && np.trim() !== "" && !isNaN(np) && parseFloat(np) >= 0 ) {
                    const c = confirm("Are you sure you want to change the price to " + np + "?");
                    if (c) {
                        window.location.href = "updatePrice.php?price=" + encodeURIComponent(np) + "&model_type=" + encodeURIComponent(model);
                    }
                }
            }
        </script>
    </body>
</html>