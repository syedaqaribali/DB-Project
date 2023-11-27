<?php
   include('includes/connect.php');
   $flag = 0;
   if(isset($_POST['adminSubmit'])){
      $email =  $_POST['adminLogin'];
      $password = $_POST['adminPassword'];
      $sql="SELECT * from `admin` where email='$email'";    
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_assoc($result);
      $emailAdmin = $row['email'];
      $passwordAdmin = $row['password'];
      if($email == $emailAdmin and $password == $passwordAdmin){
         header('location:admin.php');
      } else {
         echo "Wrong Credentials!!!";
      }
   }
   if(isset($_POST['login'])){
         $email =  $_POST['userlogin'];
         $password = $_POST['password'];
         $sql="SELECT email, `password` from student where email='$email'";    
         $result = mysqli_query($con, $sql);
         while($row = mysqli_fetch_assoc($result)){
            $emailStudent = $row['email'];
            $passwordStudent = $row['password'];
            if($email == $emailStudent and $password == $passwordStudent){
               $flag = 1;
               header("location:studentLogin.php?email='.$email.'");
            } 
         }
         $sql="SELECT email, `password` from driver where email='$email'";    
         $result = mysqli_query($con, $sql);
         while($row = mysqli_fetch_assoc($result)){
            $emailDriver = $row['email'];
            $passwordDriver = $row['password'];
            if($email == $emailDriver and $password == $passwordDriver){
               $flag = 1;
               header("location:driverLogin.php?email='.$email.'");
            } 
         }
         if($flag == 0){
            echo "wrong credentials!!!";
         }
         
   }    
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login Page</title>
      <link rel="stylesheet" href="index1.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
      <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               User Login
            </div>
            <div class="title signup">
               Admin Login
            </div>
         </div>
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" checked>
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">User</label>
               <label for="signup" class="slide signup">Admin</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">

               <form action="" class="login" method="post">
                  <div class="field">
                     <input type="email" placeholder="yourid@smiu.edu.pk" id="email" name="userlogin" autocomplete="off" required>
                  </div>
                  <div class="field">
                     <input type="password" placeholder="Password" id="password" name="password" autocomplete="off" required>
                  </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Login" name="login">
                  </div>
               </form>

               <form action="" class="signup" method="post">
                  <div class="field">
                     <input type="email" placeholder="yourid@nu.edu.pk" id="adminemail" autocomplete="off"  name="adminLogin" required>
                  </div>
                  <div class="field">
                     <input type="password" placeholder="Password" id="adminpassword" autocomplete="off" name="adminPassword" required>
                  </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Login"
                     name="adminSubmit">
                  </div>
               </form>
            </div>
         </div>
      </div>
      
      <script>
         const loginText = document.querySelector(".title-text .login");
         const loginForm = document.querySelector("form.login");
         const loginBtn = document.querySelector("label.login");
         const signupBtn = document.querySelector("label.signup");
         signupBtn.onclick = (()=>{
           loginForm.style.marginLeft = "-50%";
           loginText.style.marginLeft = "-50%";
         });
         loginBtn.onclick = (()=>{
           loginForm.style.marginLeft = "0%";
           loginText.style.marginLeft = "0%";
         });
      </script>
   </body>
</html>