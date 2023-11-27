<?php
    include('./includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="student.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bus</title>
    </head>
    <body>
        <center><h1 class="my-3">Buses</h1>
        <div class="searchStudent">
            <form>
                <label>Search Bus</label>
                <input type="text" class="cd-search table-filter" data-table="table"  id = "searchBar" placeholder="Bus No" />
            </form></center>
            
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
        </div>

        <div class="insertBus">
            <br>
            <a href="includes/addBus.php" class="btn btn-info btn-lg">Insert New Bus</a>
            <a href="admin.php" class="btn btn-success btn-lg">Back</a>
        </div>

        <div class="container my-2">
            <table class="table"   id = "table2">
            <thead>
                    <tr>
                    <th>No Plate</th>
                    <th>Bus No</th>
                    <th>Seats</th>
                    <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "select * from bus";
                        $result = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                            $noPlate = $row['NoPlate'];
                            $busNo = $row['BusNo'];
                            $seats = $row['Seats'];
                            echo '<tr>
                                <th scope="row">'.$noPlate.'</th>
                                <td>'.$busNo.'</td>
                                <td>'.$seats.'</td>
                                <td>
                                <a href="includes/updateBus.php?updateID='.$busNo.'" class="btn btn-dark">Update</a>
                                <a href="includes/removeBus.php?deleteID='.$busNo.'" class="btn btn-danger">Delete</a>
                                </td>
                                </tr>';
                        }
                    ?>   
                    
                </tbody>
            </table>
        </div>
    </body>
</html>