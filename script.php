<?php 
   require "functions.php";
 
   if(isset($_POST['category'])){
      $category = $_POST['category'];
 
      if($category === ""){
         $spec = getAllSpec();
      }else{
         $spec = getSpec($category);
      }
      echo json_encode($spec);
   }