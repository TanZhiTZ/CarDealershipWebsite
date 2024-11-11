<?php 
   require "graphFunctions.php";
 
   if(isset($_POST['category'])){
      $category = $_POST['category'];
 
      if($category === ""){
         $products_arr = getAllProducts();
      }else{
         $products_arr = getProductsByMonth($category);
      }
      echo json_encode($products_arr);
   }
?>