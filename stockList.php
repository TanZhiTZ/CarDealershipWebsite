<?php
include_once 'adminSidebar.php';

$query = "SELECT specModel, stock, color FROM stock ORDER BY id";
    
        // prepare query statement
        $stmt = mysqli_query($conn, $query);
        // execute query
        $num = mysqli_num_rows($stmt);

        if($num>0){
            // products array
            $products_arr=array();

            while ($row=mysqli_fetch_assoc($stmt)){
                extract($row);
                $product_item=array(
                    "label" => $specModel . ' ' . $color,
                    "y" => $stock,
                );
                array_push($products_arr, $product_item);
            }
        }
?>
<!DOCTYPE HTML>
<html>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Stock(s) based on model type"
	},
	axisY: {
		title: "Amount"
	},
	data: [{
		type: "column",
        indexLabel: "{y}", //Shows y value on all Data Points
		dataPoints: <?php echo json_encode($products_arr, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div style="padding: 1px; margin-left: 225px ;margin-right: 25px;">
<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 40px;"></div>
</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>  