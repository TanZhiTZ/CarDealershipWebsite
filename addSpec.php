<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'honda');

$model = mysqli_query($conn, "SELECT * FROM carinformation ORDER BY id ASC");

if (isset($_POST['add_spec'])) {
    // Collect inputs
    $requiredFields = [
        'Model', 'ModelId', 'ModelType', 'Price', 'EngineType', 'FuelSupplySystem',
        'Displacement', 'MaxPower', 'MaxTorque', 'Speed', 'Acceleration',
        'FuelConsumption', 'Front', 'Rear', 'ParkingBrake', 'Type', 'TurningRadius',
        'Length', 'Width', 'Height', 'WheelType', 'WheelSize', 'TyreSize', 'SpareTyreSize'
    ];
    $data = [];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $message[] = "$field is required.";
        } else {
            $data[$field] = htmlspecialchars(trim($_POST[$field]), ENT_QUOTES);
        }
    }

    // Check for errors
    if (!isset($message)) {
        // Prepare SQL statement
        $stmt = $conn->prepare(
            "INSERT INTO specifications (Model, ModelId, ModelType, Price, EngineType, FuelSupplySystem, Displacement, MaxPower, MaxTorque, Speed, Acceleration, FuelConsumption, Front, Rear, ParkingBrake, Type, TurningRadius, Length, Width, Height, WheelType, WheelSize, TyreSize, SpareTyreSize) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param(
                "sissssisssssssssssssss", 
                $data['Model'], $data['ModelId'], $data['ModelType'], $data['Price'], $data['EngineType'],
                $data['FuelSupplySystem'], $data['Displacement'], $data['MaxPower'], $data['MaxTorque'], 
                $data['Speed'], $data['Acceleration'], $data['FuelConsumption'], $data['Front'], 
                $data['Rear'], $data['ParkingBrake'], $data['Type'], $data['TurningRadius'], 
                $data['Length'], $data['Width'], $data['Height'], $data['WheelType'], 
                $data['WheelSize'], $data['TyreSize'], $data['SpareTyreSize']
            );

            if ($stmt->execute()) {
                $message[] = 'New specifications added successfully.';
                header("Location: addSpec.php");
            } else {
                $message[] = 'Could not add the specifications.';
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Specifications</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

</head>

<style>
a {
     text-decoration: none !important; 
}

.filter {
    text-align:left;
    margin-bottom: 50px;
    padding-left: 30px;
}

.filter ul {
    display: block;
    list-style-type: disc;
}

.filter ul li {
    list-style: none;
    font-size: 18px;
    color: #1c1c1c;
    display: inline-block;
    margin-right: 25px;
    position: relative;
    cursor: pointer;
}

.filter ul li:hover {
    color: red;
}

.filter ul li.active {
    color: red;
}

.specifications-table {
    margin-bottom: 50px;
}

table {
    display: table;
    border-collapse: separate;
    box-sizing: border-box;
    text-indent: initial;
    border-spacing: 2px;
    border-color: gray;
    width: 100%;
    font-size: 0.8125rem;
    padding-bottom: 15px;
    margin: 0 auto;
}

tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}

tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}

td {
    display: table-cell;
    vertical-align: inherit;
    padding: 20px;
    background-color: #e4e4e4;
    font-weight: 400;
    line-height: 1.0625rem;
    min-height: 70px;
    width:30%;
    margin: 1.5px;
    float: left;
    text-transform: none;
    text-align: center;
}

td:first-child {
    background-color: #fff;
    /* text-transform: uppercase; */
    font-weight: 500;
}

.ui-select .ui-btn {
    width: 100%;
}

.backbtn{
    display: block !important;
    width: 120px !important;
    height:40px !important;
    cursor: pointer !important;
    margin-left: 250px !important;
    font-size: 1.2rem !important;
    padding: 1rem 3rem !important;
    background-color: white !important; 
    color: black !important; 
    border: 2px solid red !important;
    border-radius: 8px !important;
    padding: 5px !important;
    text-align: center !important;
    }

.backbtn:hover{
    background-color: #e3e3e3 !important;
}

</style>


<body>
    <div style="padding-top: 80px;">
    <a href="javascript:history.go(-1);" class="backbtn">Back</a>
        <h1 align="center">Add Specifications</h1>
    </div>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="specifications-table">
            <table>
                <tbody>
                    <tr>
                        <td>Model</td>
                        <td>
                        <select name="ModelId" id="ModelId" required>
                            <?php while ($row = mysqli_fetch_array($model)): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['model']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <!-- Hidden input field outside of the select -->
                        <input type="hidden" name="Model" id="Model" value="">
                        </td>
                    </tr>


                    <tr>
                        <td>Model Type</td>
                        <td>
                            <input type="text" name="ModelType" id="ModelType" placeholder="Enter Model Type" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Price</td>
                        <td>
                            <input type="number" name="Price" id="Price" placeholder="Enter Price" min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td row="5" style="color:red; font-weight:bold;">Engine</td>
                    </tr>

                    <tr>
                        <td>Engine Type</td>
                        <td>
                            <input type="text" name="EngineType" id="EngineType" placeholder="Enter Engine Type" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Fuel Supply System</td>
                        <td>
                            <input type="text" name="FuelSupplySystem" id="FuelSupplySystem" placeholder="Enter Fuel Supply System" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Displacement (CC)</td>
                        <td>
                            <input type="number" name="Displacement" id="Displacement" placeholder="Enter Displacement" min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Max Power [PS(kW)@rpm]</td>
                        <td>
                            <input type="text" name="MaxPower" id="MaxPower" placeholder="Enter Max Power" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Max Torque [Nm(kg‑m)@rpm]</td>
                        <td>
                            <input type="text" name="MaxTorque" id="MaxTorque" placeholder="Enter Max Torque" required>
                        </td>
                    </tr>

                    <tr>
                        <td row="5" style="color:red; font-weight:bold;">Performance</td>
                    </tr>

                    <tr>
                        <td>Maximum Speed (km/h)</td>
                        <td>
                            <input type="number" name="Speed" id="Speed" placeholder="Enter Speed" min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Acceleration 0 ‑ 100km/h (secs)</td>
                        <td>
                            <input type="number" name="Acceleration" id="Acceleration" placeholder="Enter Acceleration" step="0.1" min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Fuel Consumption (L/100km)</td>
                        <td>
                            <input type="number" name="FuelConsumption" id="FuelConsumption" placeholder="Enter Fuel Consumption" step="0.1" min="0" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                    </tr>

                    <tr>
                        <td>Front</td>
                        <td>
                            <input type="text" name="Front" id="Front" placeholder="Enter Front Brake System" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Rear</td>
                        <td>
                            <input type="text" name="Rear" id="Rear" placeholder="Enter Rear Brake System" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Parking Brake</td>
                        <td>
                            <input type="text" name="ParkingBrake" id="ParkingBrake" placeholder="Enter Parking Brake System" required>
                        </td>
                    </tr>

                    <tr>
                        <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                    </tr>

                    <tr>
                        <td>Type</td>
                        <td>
                            <input type="text" name="Type" id="Type"  placeholder="Enter Steering Type" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Turning Radius (m)</td>
                        <td>
                            <input type="number" name="TurningRadius" id="TurningRadius" placeholder="Enter Turning Radius" step="0.1" min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                    </tr>

                    <tr>
                        <td>Length (mm)</td>
                        <td>
                            <input type="number" name="Length" id="Length" placeholder="Enter Length"  min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Width (mm)</td>
                        <td>
                            <input type="number" name="Width" id="Width" placeholder="Enter Width"  min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Height (mm)</td>
                        <td>
                            <input type="number" name="Height" id="Height" placeholder="Enter Height"  min="0" required>
                        </td>
                    </tr>

                    <tr>
                        <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                    </tr>

                    <tr>
                        <td>Wheel Type</td>
                        <td>
                            <input type="text" name="WheelType" id="WheelType"  placeholder="Enter Wheel Type" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Wheel Size</td>
                        <td>
                            <input type="text" name="WheelSize" id="WheelSize"  placeholder="Enter Wheel Size" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Tyre Size</td>
                        <td>
                            <input type="text" name="TyreSize" id="TyreSize"  placeholder="Enter Tyre Size" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Spare Tyre Size</td>
                        <td>
                            <input type="text" name="SpareTyreSize" id="SpareTyreSize"  placeholder="Enter Spare Tyre Size" required>
                        </td>
                    </tr>       
                    
                        
                </tbody>
            </table>
        </div>

        <div style="padding-bottom: 100px;">
            <input type="submit" class="ui-btn" name="add_spec" value="Add Specs" style="margin: 0 auto;">
        </div>
    </form>
    
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script>
        document.getElementById("ModelId").addEventListener("change", function () {
            var select = this;
            var selectedOption = select.options[select.selectedIndex];
            var modelValue = selectedOption.text;
            document.getElementById("Model").value = modelValue;
        });

        document.getElementById("ModelId").dispatchEvent(new Event("change"));
    </script>


</body>
</html>
