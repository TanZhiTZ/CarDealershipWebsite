<?php
include_once 'header2.php';

$select_accord = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '1'");
$select_city = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '2'");
$select_civic = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '3'");
$select_crv = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '4'");
$select_hrv = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '5'");
$select_wrv = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '6'");
$select_cityhatch = mysqli_query($conn, "SELECT * FROM specifications WHERE ModelId = '7'");
?>

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
    display: none;
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
    width:14.28%;
    margin: 1.5px;
    float: left;
    text-transform: none;
}

td:first-child {
    background-color: #fff;
    /* text-transform: uppercase; */
    font-weight: 500;
}

.ui-select .ui-btn select {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    min-height: 1.5em;
    min-height: 100%;
    height: 3em;
    max-height: 100%;
    outline: 0;
    -webkit-border-radius: inherit;
    border-radius: 3px;
}

body, input, select, textarea, button, .ui-btn {
    font-size: 1em;
    line-height: 1.3;
    font-family: sans-serif;
}

</style>


<!DOCTYPE html>

<html>
    
<head>
    <title>Comparison</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

</head>

<body>
    <div style="padding-top: 80px;">
        <h1 align="center">Specifications</h1>
    </div>

    <div class="filter">
        <label for="model" style="color:red; font-size: 20px;font-weight: bold;">Select Car Model:</label>
        <select id="filterSelect" class="ui-btn">
            <option value="Accord">Accord</option>
            <option value="City">City</option>
            <option value="City-Hatchback">City-Hatchback</option>
            <option value="Civic">Civic</option>
            <option value="CR-V">CR-V</option>
            <option value="HR-V">HR-V</option>
            <option value="WR-V">WR-V</option>
        </select>
    </div>

    <div class="specifications-table" data-category='Accord'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>
                
                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_accord, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_accord)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                
                
                    
            </tbody>
        </table>
    </div>

    <div class="specifications-table" data-category='City'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>
                
                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_city, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_city)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                
                  
            </tbody>
        </table>
    </div>

    <div class="specifications-table" data-category='Civic'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_civic, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_civic)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                
            </tbody>
        </table>
    </div>

    <div class="specifications-table" data-category='CR-V'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_crv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_crv)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                
            </tbody>
        </table>
    </div>

    <div class="specifications-table" data-category='HR-V'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_hrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_hrv)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                    
            </tbody>
        </table>
    </div>

    <div class="specifications-table" data-category='WR-V'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_wrv, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_wrv)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                    
            </tbody>
        </table>
    </div>

    <div class="specifications-table" data-category='City-Hatchback'>
        <table>
            <tbody>
                <tr>
                    <td>Models</td>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['ModelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Price</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td>RM <?php echo number_format((float)($row['Price']),'2','.',','); ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Engine</td>
                </tr>

                <tr>
                    <td>Engine Type</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['EngineType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Supply System</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['FuelSupplySystem']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Displacement (CC)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Displacement']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Power [PS(kW)@rpm]</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['MaxPower']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Max Torque [Nm(kg‑m)@rpm]</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['MaxTorque']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Performance</td>
                </tr>

                <tr>
                    <td>Maximum Speed (km/h)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Speed']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Acceleration 0 ‑ 100km/h (secs)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Acceleration']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Fuel Consumption (L/100km)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['FuelConsumption']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Brake System</td>
                </tr>

                <tr>
                    <td>Front</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Front']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Rear</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Rear']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Parking Brake</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['ParkingBrake']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Steering System</td>
                </tr>

                <tr>
                    <td>Type</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Type']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Turning Radius (m)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['TurningRadius']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Dimension</td>
                </tr>

                <tr>
                    <td>Length (mm)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Length']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Width (mm)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Width']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Height (mm)</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['Height']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td row="5" style="color:red; font-weight:bold;">Wheels & Tyres</td>
                </tr>

                <tr>
                    <td>Wheel Type</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['WheelType']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Wheel Size</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['WheelSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Tyre Size</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['TyreSize']; ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td>Spare Tyre Size</td>
                    <?php mysqli_data_seek($select_cityhatch, 0); // Reset the result set pointer ?>
                    <?php while($row = mysqli_fetch_assoc($select_cityhatch)){ ?>
                    <td><?php echo $row['SpareTyreSize']; ?></td>
                    <?php } ?>
                </tr>
                
            </tbody>
        </table>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
    $('#filterSelect').change(function() {
        const filterValue = $(this).val();

        // Hide all tables when an option is selected
        $('.specifications-table').hide();

        // Show the selected table
        $('.specifications-table[data-category="' + filterValue + '"]').show();

        // Adjust the height of the filtered rows
        adjustRowHeight();
    });

    // Show Accord table by default
    $('.specifications-table[data-category="Accord"]').show();

    // Function to adjust the height of filtered rows
    function adjustRowHeight() {
        $('.row').each(function() {
            var maxHeight = 0;
            $(this)
                .find('.specifications.active')
                .each(function() {
                    var itemHeight = $(this).height();
                    if (itemHeight > maxHeight) {
                        maxHeight = itemHeight;
                    }
                });
            $(this).find('.specifications').css('min-height', maxHeight);
        });
    }
});
    </script>
<?php
include_once 'footer.php';
?>