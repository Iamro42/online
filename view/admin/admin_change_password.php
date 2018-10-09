<?php
	session_start();
	
	if(!empty($_SESSION) && (($_SESSION['userType']=="ADMIN") )){
    //echo $_SESSION['userId'];
    //echo $_SESSION['userType'];
	}
	else{
		echo "<script>location.href = '../../index.php'</script>;";
	}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Tantransh - Question Paper</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="../css/lib/bootstrap.css">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile.css">
  <link rel="stylesheet" type="text/css" href="../css/profile.css">

<body>
<header class="header clearfix fixed-position">
    <!-- <button type="button" id="toggleMenu" class="toggle_sidenav margin-top-sm">
      <i class="fa fa-bars"></i>
    </button> -->
    <img src="../img/final%20logo.png" class="logo left-margin-sm margin-top-xs margin-logo">
    
    </header>

     <nav class="vertical_nav fixed-position mt-3 ">
        <ul id="js-menu" class="menu">
            <li class="menu--item">
                <a class="menu--link" href="../admin/" title="Admin Home">
                    <i class="menu--icon  fa fa-fw fa-home"></i>
                    <span class="menu--label">Home</span>
                </a>
            </li>

            <li class="menu--item">
                <a class="menu--link" href="../admin/admin_view_test.php" title="Conducted Tests">
                    <i class="menu--icon  fa fa-fw fa-clipboard"></i>
                    <span class="menu--label">Tests</span>
                </a>
            </li>

            <li class="menu--item">
                <a class="menu--link" href="../admin/admin_question.php" title="Question bank">
                    <i class="menu--icon  fa fa-fw fa-question-circle-o"></i>
                    <span class="menu--label">Questions</span>
                </a>
            </li>
            <li class="menu--item">
                <a class="menu--link" href="../admin/admin_users.php" title="Users">
                    <i class="menu--icon  fa fa-fw fa-user"></i>
                    <span class="menu--label">Users</span>
                </a>
            </li>
            <li class="menu--item">
                <a class="menu--link" href="../admin/admin_subjects.php" title="Subjects">
                    <i class="menu--icon  fa fa-fw fa-book"></i>
                    <span class="menu--label">Subjects</span>
                </a>
            </li>
            <li class="menu--item">
                <a class="menu--link" href="../admin/admin_result.php" title="Result">
                    <i class="menu--icon  fa fa-fw fa-pie-chart "></i>
                    <span class="menu--label">Results</span>
                </a>
            </li> 
            <li class="menu--item">
                <a class="menu--link" href="../admin/admin_change_password.php" title="Admin Home">
                    <i class="menu--icon  fa fa-fw fa-cog"></i>
                    <span class="menu--label">Settings</span>
                </a>
            </li>           
            <li class="menu--item" onclick = "signout();">
                <a class="menu--link" href="" title="Signout">
                    <i class="menu--icon  fa fa-fw fa-power-off"></i>
                    <span class="menu--label">Sign Out</span>
                </a>
            </li>
        </ul>

        <button id="collapse_menu" class="collapse_menu">
            <i class="collapse_menu--icon  fa fa-fw"></i>
            <span class="collapse_menu--label"></span>
        </button>
        
    </nav>


  <div class="wrapper">
    <section class=" margin-top-md">
        <div class = "row">
            <div class = "col-md-6 col-sm-12 m-auto">
                <h4 class = "mrt-8 text-center">Change Password</h4>
                <div class ="card">
                    <div class="card-body">
                        <!-- <label class = "form-label"> </label> -->
                        <div class = "mb-2 p-1">
                            <div class ="text-sm"> Enter Old Password </div>    
                                <input type = "password" id = "old_pass" placeholder="Enter old password" class="form-control bg-trans-white text-colour" >
                                <span class = "text-xs color-red" id = "oldPassErr"></span>
                        </div>
                        <div class = "mb-2 p-1">
                            <div class ="text-sm"> Enter New Password </div>    
                                <input type = "password" id = "new_pass" placeholder="Enter new password" class="form-control bg-trans-white text-colour" onblur="passwordLength()">
                                <span class = "text-xs color-red" id = "newPassErr"></span>
                        </div>
                        <div class = "mb-2 p-1">
                            <div class ="text-sm"> Enter Confirm Password </div>    
                                <input type = "password" id = "conf_pass" placeholder="Enter new password again" class="form-control bg-trans-white text-colour" onblur = "checkConfirmPass()">
                                <span class = "text-xs color-red" id = "confPassErr"></span>
                        </div>
                        <span class = "text-xs color-red mb-2" id = "passErr"></span>
                        <div class = "mb-2 p-1">
                            <button type="button" class="btn btn-success btn-sm update" onclick = "update_password()">Update Password</button>
                            <button type="button" class="btn btn-secondary btn-sm" id = "close_window">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
       
    </section>
    
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm ">
            <div class="modal-content">
                <div class="modal-body p-4 ">
                <div class = "h1 text-center"><i class = "fa fa-check-circle text-success"></i></div>
                <p class = "text-center h6 userInfo">Password Updated Successfully! </p>
                </div>
            </div>
        </div>
    </div>

</div>
    <!-- External javascript -->
    <script type = "text/javascript" src="../js/lib/jquery-3.3.1.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-3.2.1.slim.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/jquery-1.9.1.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/popper.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/bootstrap.js"></script>
    
    <!-- User Defined Javascript -->
   
	<script type="text/javascript" src="../js/inputValidations.js"></script>
    <script type="text/javascript" src="../js/validations.js"></script>
    <script type="text/javascript" src="../js/admin_change_pass.js"></script>
    <script type="text/javascript" src="../js/main.js"></script> 
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>

    <script>
        checkRequired('#old_pass','#oldPassErr');
        checkRequired('#new_pass','#newPassErr');
        checkRequired('#conf_pass','#confPassErr');        
    </script>
  
</body>
</html>