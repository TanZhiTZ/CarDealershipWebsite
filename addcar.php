
<?php
include_once 'adminSidebar.php';

if (isset($_POST['add'])) {

  $model = $_POST['name'];
  $home_image = $_FILES['image9']['name'];
  $model_information = $_POST['information'];
  $model_pic = $_FILES['image1']['name'];
  $spec_pic1 = $_FILES['image2']['name'];
  $spec_pic2 = $_FILES['image3']['name'];
  $spec_pic3 = $_FILES['image4']['name'];
  $design_pic1 = $_FILES['image5']['name'];
  $design_pic2 = $_FILES['image6']['name'];
  $design_pic3 = $_FILES['image7']['name'];
  $design_pic4 = $_FILES['image8']['name'];
  $spec_desc1 = $_POST['specdesc1'];
  $spec_desc2 = $_POST['specdesc2'];
  $spec_desc3 = $_POST['specdesc3'];
  $design_desc1 = $_POST['designdesc1'];
  $design_desc2 = $_POST['designdesc2'];
  $design_desc3 = $_POST['designdesc3'];
  $design_desc4 = $_POST['designdesc4'];
  
  // Define an array of file input names and their respective temporary file names
  $file_inputs = [
    'image1' => $_FILES['image1']['tmp_name'],
    'image2' => $_FILES['image2']['tmp_name'],
    'image3' => $_FILES['image3']['tmp_name'],
    'image4' => $_FILES['image4']['tmp_name'],
    'image5' => $_FILES['image5']['tmp_name'],
    'image6' => $_FILES['image6']['tmp_name'],
    'image7' => $_FILES['image7']['tmp_name'],
    'image8' => $_FILES['image8']['tmp_name'],
    'image9' => $_FILES['image9']['tmp_name']
];

  if (
    empty($model) || empty($home_image) || empty($model_information) || empty($model_pic) || empty($spec_pic1) || empty($spec_pic2) || empty($spec_pic3) || empty($design_pic1) || empty($design_pic2) ||
    empty($design_pic3) || empty($design_pic4) || empty($spec_desc1) || empty($spec_desc2) || empty($spec_desc3) || empty($design_desc1) || empty($design_desc2) ||
    empty($design_desc3) || empty($design_desc4)
  ) {
    echo "<script>alert('Please fill in the all the information and image required.')</script>";
  } else {
    $insert = "INSERT INTO carinformation(model, homeimage, modelinformation, modelpic, specpic1, specpic2, specpic3, designpic1, designpic2, designpic3, designpic4, specdesc1, 
      specdesc2, specdesc3, designdesc1, designdesc2, designdesc3, designdesc4) VALUES('$model', '$home_image', '$model_information', '$model_pic', '$spec_pic1', '$spec_pic2', 
      '$spec_pic3', '$design_pic1', '$design_pic2', '$design_pic3', '$design_pic4', '$spec_desc1', '$spec_desc2', '$spec_desc3', '$design_desc1', '$design_desc2', '$design_desc3', 
      '$design_desc4')";

    $upload = mysqli_query($conn, $insert);
    if ($upload) {
      // Loop through the file inputs and move each file to its respective folder
      foreach ($file_inputs as $input_name => $tmp_name) {
        // Define the target folder for each image
        $image_folder = 'img/';

        // Construct the target file path
        $target_file = $image_folder . $_FILES[$input_name]['name'];

        if (move_uploaded_file($tmp_name, $target_file)) {
          echo "<script>alert('Image for $input_name uploaded successfully.')</script>";
        } else {
          echo "<script>alert('Failed to upload image for $input_name.')</script>";
        }
      }
      echo "<script>alert('New model added.')</script>";
    } else {
      echo "<script>alert('Failed to add model.')</script>";
    }
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Honda Car Dealership &bull; Car Information</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/style.css">

  <style>
    input[type="submit"] {
      background-color: #a81c40;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
      box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.3);
      width: 70%;
    }
  </style>

  <script>
    //model image
    function previewImage1() {
      var fileInput = document.getElementById('image1');
      var imagePreview = document.getElementById('image-preview1');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //spec pic 1
    function previewImage2() {
      var fileInput = document.getElementById('image2');
      var imagePreview = document.getElementById('image-preview2');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //spec pic 2
    function previewImage3() {
      var fileInput = document.getElementById('image3');
      var imagePreview = document.getElementById('image-preview3');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //spec pic 3
    function previewImage4() {
      var fileInput = document.getElementById('image4');
      var imagePreview = document.getElementById('image-preview4');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //design pic 1
    function previewImage5() {
      var fileInput = document.getElementById('image5');
      var imagePreview = document.getElementById('image-preview5');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //design pic 2
    function previewImage6() {
      var fileInput = document.getElementById('image6');
      var imagePreview = document.getElementById('image-preview6');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //design pic 3
    function previewImage7() {
      var fileInput = document.getElementById('image7');
      var imagePreview = document.getElementById('image-preview7');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    function previewImage8() {
      var fileInput = document.getElementById('image8');
      var imagePreview = document.getElementById('image-preview8');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

    //home image
    function previewImage9() {
      var fileInput = document.getElementById('image9');
      var imagePreview = document.getElementById('image-preview9');
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = 'img/transparent.jpg'; // Set default transparent image
      }
    }

  </script>
</head>

<body id="grad">
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <!--car model-->
    <div class="main">
      <img id="image-preview1" src="img/transparent.jpg" class="car-model" alt="Selected Image">
      <input type="file" accept="image/png, image/jpeg, image/jpg" name="image1" id="image1" class="box"
        onchange="previewImage1()">
      <div>
        <input type="text" id="name" placeholder="Enter car model name" name="name">
      </div>
      <div>
        <textarea id="information" name="information" placeholder="Enter car description" row="5"
          style="width: 305.02px;height: 100px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
      </div>


      </br>
      <hr style="width: 90%;" /></br></br>

      <!--car specification-->
      <div class="row align-items-center" style="width: 70%;">
        <div class="col" style="display:block;">
          <img id="image-preview2" src="img/transparent.jpg" class="car-spec" alt="Selected Image">
          <input type="file" accept="image/png, image/jpeg, image/jpg" name="image2" id="image2" class="box"
            onchange="previewImage2()">
        </div>
        <div class="col" style="display:block;">
          <img id="image-preview3" src="img/transparent.jpg" class="car-spec" alt="Selected Image">
          <input type="file" accept="image/png, image/jpeg, image/jpg" name="image3" id="image3" class="box"
            onchange="previewImage3()">
        </div>
        <div class="col" style="display:block;">
          <img id="image-preview4" src="img/transparent.jpg" class="car-spec" alt="Selected Image">
          <input type="file" accept="image/png, image/jpeg, image/jpg" name="image4" id="image4" class="box"
            onchange="previewImage4()">
        </div>
      </div>

      <div class="row align-items-center" style="width: 70%;">
        <div class="col">
          <textarea id="description" name="specdesc1" placeholder="Enter car spec 1" row="5"
            style="width: 305.02px;height: 100px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
        </div>
        <div class="col">
          <textarea id="description" name="specdesc2" placeholder="Enter car spec2" row="5"
            style="width: 305.02px;height: 100px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
        </div>
        <div class="col">
          <textarea id="description" name="specdesc3" placeholder="Enter car spec3" row="5"
            style="width: 305.02px;height: 100px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
        </div>
      </div>

      </br></br>
      </br></br>
      <!--interior design-->
      <div class="container" style="width: 66%;">
        <div class="row align-items-center">
          <div class="col">
            <textarea id="description" name="designdesc1" placeholder="Enter car description" row="15"
              style="width: 305.02px;height: 200px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
          </div>
          <div class="col" style="display:block;">
            <img id="image-preview5" src="img/transparent.jpg" width="300" height="300" alt="Selected Image">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image5" id="image5" class="box"
              onchange="previewImage5()">
          </div>
        </div>
        </br>
        <div class="row align-items-center">
          <div class="col" style="display:block;">
            <img id="image-preview6" src="img/transparent.jpg" width="300" height="300" alt="Selected Image">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image6" id="image6" class="box"
              onchange="previewImage6()">
          </div>
          <div class="col">
            <textarea id="description" name="designdesc2" placeholder="Enter car description" row="15"
              style="width: 305.02px;height: 200px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
          </div>
        </div>
        </br>
        <div class="row align-items-center">
          <div class="col">
            <textarea id="description" name="designdesc3" placeholder="Enter car description" row="15"
              style="width: 305.02px;height: 200px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
          </div>
          <div class="col" style="display:block;">
            <img id="image-preview7" src="img/transparent.jpg" width="300" height="300" alt="Selected Image">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image7" id="image7" class="box"
              onchange="previewImage7()">
          </div>
        </div>
        </br>
        <div class="row align-items-center">
          <div class="col" style="display:block;">
            <img id="image-preview8" src="img/transparent.jpg" width="300" height="300" alt="Selected Image">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image8" id="image8" class="box"
              onchange="previewImage8()">
          </div>
          <div class="col">
            <textarea id="description" name="designdesc4" placeholder="Enter car description" row="15"
              style="width: 305.02px;height: 200px;margin: 10px;padding: 10px;font-size: 16px;border-radius: 5px;border: none;box-shadow: 2px 2px 2px rgba(0,0,0,0.3);"></textarea>
          </div>
        </div>
        </br>

        <div class="row align-items-center">
          <div class="col">
            <p>Select a image display at the home page.</p>
          </div>
          <div class="col" style="display:block;">
            <img id="image-preview9" src="img/transparent.jpg" width="450" height="300" alt="Selected Image">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image9" id="image9" class="box"
              onchange="previewImage9()">
          </div>
        </div>

        <div class="text-center" style="padding:30px;">
          <button class="btn-car-model hover-container" name="add" type="submit">
            <div class="btn-car-model-overlay"></div>
            <b>Add Model</b>
          </button>
        </div>



      </div>

      <!--Pricing-->

      </br>



      </br></br></br>
    </div>
  </form>
</body>

</html>