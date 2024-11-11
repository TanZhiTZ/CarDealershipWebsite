<?php
include_once 'adminSidebar.php';

//get current month
$month = date('m');

$query = "SELECT specModel, soldnum, color, year FROM carsold WHERE month = $month ORDER BY soldnum";
    
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
window.onload = function chart () {
 
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
<h3 id="month" class="month" style="text-align: center; margin-top: 40px; font-weight: 600;"></h3>
<select name="months" class="months" id="months">
  <option value="1">January</option>
  <option value="2">February</option>
  <option value="3">March</option>
  <option value="4">April</option>
  <option value="5">May</option>
  <option value="6">June</option>
  <option value="7">July</option>
  <option value="8">August</option>
  <option value="9">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
</select>
<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 20px;"></div>
<script>
    function getMonthName(monthNumber) {
  const date = new Date();
  date.setMonth(monthNumber - 1);

  return date.toLocaleString('en-US', {
    month: 'long',
  });
}
    //get current month
    const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    const d = new Date();
    let monthName = month[d.getMonth()];
    document.getElementById("month").innerHTML = "Car sold during " + monthName;


    let selectMonth = document.querySelector(".months");
    
    selectMonth.addEventListener("change", function(){
        let categoryName = this.value;
        selectedMonth = getMonthName(this.value);
        document.getElementById("month").innerHTML = "Car sold during " + selectedMonth;
        
        let http = new XMLHttpRequest();
   
        http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
//            console.log(this.responseText);
//            console.log(JSON.parse(this.responseText));
         let response = JSON.parse(this.responseText);

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
		dataPoints: response
	}]
    
});
chart.render();
         
      };
   }
    
   http.open('POST', "graphScript.php", true);
   http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
   http.send("category="+categoryName);
   
    });

</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>  