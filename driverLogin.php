<?php
    include('./includes/connect.php');
?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="user.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
        
        <title>Driver</title>
    </head>
    <body>
    <div class="alert alert-warning" role="alert">
        <a href="index1.php" class="btn btn-danger btn-sm" id="logout">
          <span class="glyphicon glyphicon-log-out"></span> Log out
        </a>        
    </div>
        <form method="post">
            <div class="alert alert-primary" role="alert">
                <input style="margin-right:30px;" id = "search0" type="text"  placeholder="Search by your ID" name="id" onkeyup="searchBus()" required>
                
                <button type="submit" class="btn btn-success btn-sm  my-3" name="check" onclick="searchBus()">Check Notifications</button>
                
            </div>
        </form>

        <script>
            function searchBus() {
                // Declare variables
                var input, filter, table, tr, td, i;
                input = document.getElementById("search0");
                filter = input.value.toUpperCase();
                table = document.getElementById("alertInfo");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
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

        <div class="container my-5">
            <center>
            <table id = "alertInfo" class="your-table tableFixHead">
                <thead>
                    <tr>   
                    <th>Driver's ID</th>                         
                    <th>Stop Name</th>
                    <th>Student ID</th>
                    <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT driverID, stopName, rollNo from alert";
                        $result = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                            $id = $row['driverID'];
                            $name =  $row['stopName'];
                            $roll = $row['rollNo'];
                            echo '<tbody>
                                <tr>
                                <td>'.$id.'</td>
                                <td>'.$name.'</td>
                                <td>'.$roll.'</td>
                                <td><a href="removeAlert.php?id1='.$id.'&id2='.$name.'&id3='.$roll.'" class="btn btn-info btn-sm">Picked</a></td>
                                </tr>
                                </tbody>';
                        }
                    ?>
                </tbody>
            </table>
            </center>
        </div>

        <div class="alert alert-primary" role="alert">        
            <form action="post">
            <button type="button" class="btn btn-success btn-sm  my-3" name="start" onclick="getLocation()">Share Live Location</button>  
            <button type="submit" class="btn btn-success btn-sm  my-3" name="stop" onclick="stopLocation()" style="float:right;">Stop Sharing</button>  
            </form>              
        </div>

        <div id = "map">        
        

            <script>
                let id;
                function getLocation() {
                    if (navigator.geolocation) {
                        id = navigator.geolocation.watchPosition(position => {
                        const {latitude, longitude} = position.coords;
                        map.innerHTML = '<iframe width="700" height="300" src = "https://maps.google.com/maps?q='+latitude+','+longitude+'&amp;z=15&amp;output=embed"></iframe>';
                        });
                    }
                }

                function stopLocation() {
                    navigator.geolocation.clearWatch(id);
                }
            </script>
        </div>
    </body>
</html>