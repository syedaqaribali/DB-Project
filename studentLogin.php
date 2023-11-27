<?php
    include('./includes/connect.php');
    if(isset($_POST['alert'])){
        $id = $_POST['id'];
        $roll = $_POST['roll'];
        $stop = $_POST['stop1'];
        $sql = "INSERT INTO alert (driverID, rollNo, stopName) VALUES($id, '$roll', '$stop')";
        $result = mysqli_query($con, $sql);
        if($result){
            echo "<script>alert('Driver Notified!!!');</script>";
        }
        else{
            die(mysqli_error($con));
        }
    }
    

?>
<style>
    #busInfo{
        width:60%;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    
    <title>Student</title>
</head>

<body>
    <div class="alert alert-warning" role="alert">
        <a href="index1.php" class="btn btn-danger btn-sm" id="logout">
          <span class="glyphicon glyphicon-log-out"></span> Log out
        </a>        
    </div>
    <div class="alert alert-info DriverBusInfo" role="alert">
        Drivers And Buses Info
    </div>
    <form>
        <input type="text" class="cd-search table-filter" data-table="your-table" id = "search0" placeholder="Driver Name/Bus ">
        <button class="btn btn-info btn-sm  my-3" name="submit">Search</button>
    </form> 
        
    <script>
        (function() {
            'use strict';

            var TableFilter = (function() {
                var Arr = Array.prototype;
                var input;

            function onInputEvent(e) {
                input = e.target;
                var table1 = document.getElementsByClassName(input.getAttribute('data-table'));
                Arr.forEach.call(table1, function(table) {
                    Arr.forEach.call(table.tBodies, function(tbody) {
                        Arr.forEach.call(tbody.rows, filter);
                    });
                });
            }

            function filter(row) {
                var text = row.textContent.toLowerCase();
                var val = input.value.toLowerCase();
                row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
            }

        return {
        init: function() {
            var inputs = document.getElementsByClassName('table-filter');
            Arr.forEach.call(inputs, function(input) {
                input.oninput = onInputEvent;
            });
        }
            };

        })();

            TableFilter.init(); 
            })();
    </script>
    <div class="container my-5">
        <table id = "busInfo" class="your-table tableFixHead">
            <thead>
                <tr>   
                <th>Driver's Name</th>                         
                <th>Driver's ID</th>
                <th>Contact No</th>
                <th>Bus</th>
                <th>No Plate</th>
                <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT driver.id, driver.Name, bus.BusNo, driver.contactNo, bus.NoPlate from bus join driver on bus.BusNo = driver.busNo";
                    $result = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($result)){                        
                        $name =  $row['Name'];
                        $id = $row['id'];
                        $no =  $row['contactNo'];
                        $busNo = $row['BusNo'];
                        $seat = $row['NoPlate'];
                        echo '<tbody>
                            <tr>
                            <td>'.$name.'</th>
                            <td>'.$id.'</th>
                            <td>'.$no.'</td>
                            <td>'.$busNo.'</td>   
                            <td>'.$seat.'</td> 
                            <td><a href="#" class="btn btn-success btn-sm">Live Location</a></td>
                            </tr>
                            </tbody>';
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="alert alert-info" role="alert">
        Routes Info
    </div>
    <form>
        <input type="text" id = "search1" placeholder=" Stop Name" onkeyup="searchRoute()">
        <button class="btn btn-info btn-sm  my-3" name="submit">Search</button>
    </form> 
    
    <div class="container my-5">
        <table id = "RouteInfo" class="tableFixHead">
            <thead>
                <tr>                            
                <th>Stop Name</th>
                <th>Time</th>
                <th>Route</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `stop` order by `Name`";
                    $result = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($result)){
                        $name =  $row['Name'];
                        $no =  $row['time'];
                        $busNo = $row['BusNo'];
                        echo '<tbody>
                            <tr>
                            <td>'.$name.'</th>
                            <td>'.$no.'</td>
                            <td>'.$busNo.'</td>   
                            </tr>
                            </tbody>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function searchRoute() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("search1");
            filter = input.value.toUpperCase();
            table = document.getElementById("RouteInfo");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the        search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        }
    </script>

    <div class="alert alert-info AlertDriver" role="alert">
        Alert Driver To Stop For You
    </div>

    <form method="post">
        <input style="margin-right:30px;" type="text"  placeholder="Driver ID" name="id">
        <input style="margin-right:30px;" type="text"  placeholder="Your Roll No (19K-1234)" name="roll">
        <!--<input type="text"  placeholder="Stop Name" name="stop">
    -->
        <label for="stop">Stop Name</label>
        <select name="stop1" id="stop1" required>
            <option disabled selected>select</option>
            <?php
                $result = mysqli_query($con, "SELECT * from `stop`");
                while($data = mysqli_fetch_array($result)){
                    echo "<option value='".$data['Name']."'>".$data['Name']."</option>";
                }

            ?>
        
        </select>
        <button type="submit" value="submit" class="btn btn-warning btn-sm  my-3" name="alert">Alert</button>
    </form> 
</body>
</html>