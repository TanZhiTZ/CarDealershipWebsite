<?php 
function connect(){
   $mysqli = new mysqli('localhost', 'root', '', 'honda');
   if($mysqli->connect_errno != 0){
      return $mysqli->connect_error;
   }else{
      $mysqli->set_charset("utf8mb4");	
   }
   return $mysqli;
}

function getProductsByMonth($month){
   $mysqli = connect();
   $res = $mysqli->query("SELECT * FROM carsold WHERE month = $month ORDER BY soldnum");
   if ($row = $res->fetch_assoc()) {
      $products_arr=array();
    do{
      extract($row);
//      print_r($row);
      $product_item=array(
         'label' => $specModel . ' ' . $color,
         'y' => (int)$soldnum,
     );
     array_push($products_arr, $product_item);
     }while($row = $res->fetch_assoc());
   }else {
    return;
   }
//   print_r($products_arr);
   return $products_arr;
}
?>