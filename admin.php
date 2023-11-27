<?php
    include('./includes/connect.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="homepage.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
        <style>
            .tableFixHead {
                overflow-y: auto;
                height: 106px;
            }
            .tableFixHead thead th {
                position: sticky;
                top: 0;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                padding: 8px 16px;
               
            }
            th {
                background: #eee;
                background-color: white;
                
            }
            td{
                color: white;
            }
            .DriverBusInfo{
                width:45pc;
            }
        </style>
    </head>
    <body>
        <br>
        <!-- navbar sidepanel in extras-->
        <div class="alert alert-warning" role="alert">
            <a href="index1.php" class="btn btn-danger btn-sm" id="logout">
            <span class="glyphicon glyphicon-log-out"></span> Log out
            </a>        
        </div>

        <div class="navbar">
            <nav>
                <ul id='Options'>
                    <li><a href='student.php'>Students</a></li>
                    <li><a href='driver.php'>Drivers</a></li>
                    <li><a href='stop.php'>Stops</a></li>
                    <li><a href='bus.php'>Buses</a></li>
                </ul>
            </nav>
        </div>
        <center>
            <div id = "info">
                <div class = "routes">
                    <br>
                    <div class="alert alert-info DriverBusInfo" role="alert">
                        Routes
                    </div>
                    <form method="post">
                        <div class="mb3"> 
                            <input type="text" name="route" id="search1" placeholder = "1A" onkeyup="searchRoute()">
                        
                        <button class="btn btn-info btn-sm  my-3" name="submit">Search</button>
                        </div>
                    </form>
                    <div class="container my-5">
                        <table id = "RouteInfo">
                            <thead>
                                <tr>
                                <th>Route</th>                            
                                <th>Stop Name</th>
                                <th>Time</th>
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
                                            <td>'.$busNo.'</td>
                                            <td>'.$name.'</th>
                                            <td>'.$no.'</td>   
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
                </div>
                
                <div class="DriverAndBuses">
                    <div class="alert alert-info DriverBusInfo" role="alert">
                        Drivers And Buses Info
                    </div>
                    <br>
                    <form>
                        <input type="text" class="cd-search table-filter" data-table="your-table"  id = "searchBar" placeholder="Enter to search" />
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
                        <table id = "table2" class="your-table">
                            <thead>
                                <tr>                            
                                <th>Driver's Name</th>
                                <th>Contact No</th>
                                <th>Bus</th>
                                <th>Seats Left</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT driver.Name, bus.BusNo, driver.contactNo, bus.Seats from bus join driver on bus.BusNo = driver.busNo";
                                    $result = mysqli_query($con, $sql);
                                    while($row=mysqli_fetch_assoc($result)){
                                        $name =  $row['Name'];
                                        $no =  $row['contactNo'];
                                        $busNo = $row['BusNo'];
                                        $seat = $row['Seats'];
                                        echo '<tbody>
                                            <tr>
                                            <td>'.$name.'</th>
                                            <td>'.$no.'</td>
                                            <td>'.$busNo.'</td>   
                                            <td>'.$seat.'</td> 
                                            </tr>
                                            </tbody>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="StudentsOnStops">
                    <div class="alert alert-info DriverBusInfo" role="alert">
                       Students On Stop
                    </div>
                    <br>
                    <form>
                        <input id = "search0" type="text" placeholder="Enter to search" onkeyup="searchStop()">
                        <button class="btn btn-info btn-sm  my-3" name="submit">Search</button>
                    </form>
                    
                    <script>
                        function searchStop() {
                            // Declare variables
                            var input, filter, table, tr, td, i;
                            input = document.getElementById("search0");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("stopInfo");
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
                        <table id = "stopInfo" class="tableFixHead">
                            <thead>
                                <tr>                            
                                <th scope="col">Stop</th>
                                <th scope="col">Number of Passengers</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT count(rollNo)  as Passengers, `Stop` from student group by `Stop` order by count(rollNo) desc";
                                    $result = mysqli_query($con, $sql);
                                    while($row=mysqli_fetch_assoc($result)){
                                        $name =  $row['Stop'];
                                        $no =  $row['Passengers'];
                                        echo '<tbody>
                                            <tr>
                                            <td>'.$name.'</td>
                                            <td>'.$no.'</td>
                        
                                            </tr>
                                            </tbody>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </center>                        

    </body>

    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "250px";
        }
        /* Set the width of the sidebar to 0 (hide it) */
        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>
</html>