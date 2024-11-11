<?php
include_once 'adminSidebar.php';

//get current month
$month = date('m');

$total = 0;

$query = "SELECT specModel, soldnum, price, color, year FROM carsold WHERE month = $month ORDER BY soldnum";
    
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
                    "y" => $soldnum,
                );
                array_push($products_arr, $product_item);
                $total = $total + ($soldnum * $price);
            }
        }
?>
<!DOCTYPE HTML>
<html>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: ""
	},
	axisY: {
		title: "Car sold"
	},
    axisY2: {
        includeZero: true
    },
    axisX: {
		title: "Car Model",
        margin: 20,
        titleFontSize: 30,
        labelPlacement: "inside",
        tickPlacement: "inside"
	},
	data: [{
		type: "bar",
        axisYType: "secondary",
        
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
<h3 id="month" style="text-align: center; margin-top: 40px; font-weight: 600;"></h3>
<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 20px;"></div>
<div style="float:right;">Total Earnings this month : RM <strong><?php echo number_format((float)$total, '2', '.', ',');?></strong></div>
</div>
<script>
    //get current month
    const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    const d = new Date();
    let monthName = month[d.getMonth()];
    document.getElementById("month").innerHTML = "Car sold during " + monthName;
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>  