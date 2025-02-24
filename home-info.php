<?php
require 'authentication.php'; // admin authentication check 

// auth check
if(isset($_SESSION['admin_id'])){
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['admin_name'];
  $security_key = $_SESSION['security_key'];
  if ($user_id != NULL && $security_key != NULL) {
    header('Location: task-info.php');
  }
}


if(isset($_POST['login_btn'])){
 $info = $obj_admin->admin_login_check($_POST);
}

$page_name="Home";
include("include/login_header.php");




?>                                                         

<div class="row">


    <div class="col-md-4 col-md-offset-3">
    
        <div class="well" style="position:relative;top:20vh;">
        <img src="assets/images/front.PNG" 
     alt="EarthTab Savings Logo" 
     class="login-logo" 
     style="max-width: 200px;  display: block; margin-left: auto; margin-right: auto; border-radius: 0;">


            <center>
            
    

            
            
            </center>
            <form class="form-horizontal form-custom-login" action="" method="POST">
                <div class="form-heading">
                    <h2 class="text-center">Login Page</h2>
                </div>

                <!-- <div class="login-gap"></div> -->
                <?php if(isset($info)){ ?>
                <h5 class="alert alert-danger"><?php echo $info; ?></h5>
                <?php } ?>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" required />
                </div>
                <div class="form-group" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
                    <input type="password" class="form-control" placeholder="Password" name="admin_password" required />
                </div>
                <button type="submit" name="login_btn" class="btn btn-info pull-right">Login</button>
                <button  class="mt-6 bg-blue-500 text-white font-bold py-3 px-8 rounded-full text-xl">
        <a href="index.php">Sign Up</a>
        </button>

            </form>


        </div>

    </div>

</div>

