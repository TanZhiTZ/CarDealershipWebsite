<?php
include_once 'adminSidebar.php';

// Check if user is logged in and has the role of Super Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    echo "<script>
        alert('Access denied. Only Super Admins can access this page.');
        window.location.href = 'adminIndex.php';
    </script>";
    exit;
}

$query = "SELECT specModel, soldnum, color, year FROM carsold ORDER BY soldnum";
    
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
		text: "Car sold overview (All Time)",
        titleFontSize: 41
	},
    axisY2: {
        title: "Numbers of Car",
        titleFontSize: 17,
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
<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 40px;"></div>
</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>  