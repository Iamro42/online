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
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/desktop.css">
  <link rel="stylesheet" type="text/css" href="../css/profile.css">
  <link rel="stylesheet" type="text/css" href="../css/mobile.css">
  <!-- <link rel="stylesheet" type="text/css" href="../css/media-queries.css"> -->
  <link rel="stylesheet" type="text/css" href="../css/profile.css">
  <!-- <link href="../css/toastr.css" rel="stylesheet"> -->
  
</head>

<body>

  <header class="header clearfix fixed-position">
    <!-- <button type="button" id="toggleMenu" class="toggle_sidenav margin-top-sm">
      <i class="fa fa-bars"></i>
    </button> -->
    <img src="../img/final%20logo.png" class="logo left-margin-sm margin-top-xs margin-logo">
    <div class ="profile"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="menu--icon fa fa-fw fa-user"></i></div>
     
        <div class="dropdown-menu dropdown-menu-right " style="width: 15rem;">
            <div class ="col-md-12 bg-secondary text-light text-center p-2" id="user_name">Roshan Bagde </div>
            
            <div class = "col-md-12 p-0 d-inline-block">                
                <table class="table m-0">
                        <tbody class = "text-xs text-dark">
                        <tr>
                            <td colspan = "2" class = "text-center"><img src ="../image/images/user-2.png" width="80px">
                            </td>
                        </tr>
                        <tr>                                                       
                            <td class = "pl-3">Email</td>
                            <td id = "email_id"></td>
                        </tr>                            
                        </tbody>
                    </table>
                </div>
                <br>
                
                <div class = " col-md-12 p-2 text-sm text-center bg-secondary">
                    <a class = "link-sign-out" href = '#'  onclick = "signout();" ><i class = "fa fa-power-off text-light mx-2"></i>Sign Out</a>
                </div> 
        </div>
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
    <section class="margin-top-md ">
        <div class="col-md-4 pull-left top-margin mb-3" id="show_qp_filter">
            <div class="card shadow">
                <div class="card-body bg-info ">
                <div class="col-12  height-lg box-padding">
                    <h6 class="text-white"> Generate New Test</h6>

                        <!-- Subjects are here -->
                        <div class="top-margin">
                            <select class="form-control filter_questions text-sm" id = "question_subject" >                                        
                                <option value = -2>Select Subject</option>
                            </select> 
                            <span id = "subject_err" class="color-red text-sm"> </span>
                        </div>
                        
                        <div class="top-margin">
                            <label class = "margin-top-xs text-light ">Easy :</label>
                            <input type = "text" placeholder = "00" onkeypress="return isNumberKey(event)" onkeyup="return easy()" class = "float-right text-sm w-50 p-2 que_type easy" id = "easy_que">
                        </div>
                        <span id = "enter_question_easy" class=" color-red text-sm"> </span>                       
                        <div class="top-margin">
                            <label class = "margin-top-xs text-light">Medium :</label>                        
                            <input type = "text" placeholder = "00" onkeypress="return isNumberKey(event)" onkeyup="return medium()" class = "float-right text-sm w-50 p-2 que_type medium" id = "medium_que">
                        </div>
                        <span id = "enter_question_medium" class=" color-red text-sm"> </span>
                        <div class="top-margin ">
                            <label class = "margin-top-xs text-light">Hard :</label>                        
                            <input type = "text" placeholder = "00" onkeypress="return isNumberKey(event)" onkeyup="return hard()" class = "float-right text-sm w-50 p-2 que_type hard" id = "tough_que">
                        </div>
                        <span id = "enter_question_hard" class=" mb-3 color-red text-sm"> </span>
                        <span id = "enter_question_err" class="color-red text-sm"> </span>
                        <span id = "available_question_err" class="color-red text-sm"> </span>
                        <div class="top-margin">
                            <select class="form-control filter_questions text-sm" id = "negative_marking" >                                        
                                <option value = -2>Select Negative Marking </option>
                                <option value = 0>None</option>
                                <option value = 0.25>25% Marks per wrong answer</option>
                                <option value = 0.50>50% Marks per wrong answer</option>
                                <option value = 0.75>75% Marks per wrong answer</option>
                                <option value = 1.00>100% Marks per wrong answer</option>
                            </select> 
                            <span id = "negative_err" class="color-red text-sm"> </span>
                        </div>
                        <select class="form-control top-margin filter_questions text-sm" id = "time_sub" >                                        
                            <option value = -2>Select Exam Time</option>
                            <option value = 15>15 Minutes</option>
                            <option value = 20>20 Minutes</option>
                            <option value = 30>30 Minutes</option>
                            <option value = 45>45 Minutes</option>
                            <option value = 60>60 Minutes</option>
                            <option value = 75>75 Minutes</option>
                            <option value = 90>90 Minutes</option>
                        </select>
                        <span id = "time_err" class="color-red text-sm mt-2"> </span>

                        <select class = "form-control top-margin filter_questions text-sm" id = "passing_marks">
                            <option value = -2>Select Passing Marks</option>
                            <option value = 20>Minimum 20%</option>
                            <option value = 30>Minimum 30%</option>
                            <option value = 40>Minimum 40%</option>
                            <option value = 50>Minimum 50%</option>
                            <option value = 60>Minimum 60%</option>
                            <option value = 70>Minimum 70%</option>
                            <option value = 80>Minimum 80%</option>
                            <option value = 90>Minimum 90%</option>
                            <option value = 100>Minimum 100%</option>
                        </select>
                        <span id = "passing_err" class="color-red text-sm mt-2"> </span>
                        <span id = "sub_err" class="color-red text-sm mt-2"> </span>
             
                        <!-- <div class="top-margin">
                            <button class="btn btn-danger float-right" id = "filter_btn" onclick = "filter_question()">Filter</button>
                        </div> -->
                        <div class="top-margin">
                            <button class="btn btn-sm btn-danger btn-block" id = "create" onclick = "create_normal_test()">Create</button>
                            <!-- <button id="toastr-danger">Trial</button> -->
                        </div>
                        <hr>

                        <h6 class="text-white"> Generate Random Test</h6>
                        <div class="top-margin">
                            <select class="form-control filter_questions text-sm" id = "question_subject_random" >                                        
                                <option value = -2> All Subjects</option>                                
                            </select> 
                            <span id = "random_sub_err" class="color-red text-sm"> </span>
                        </div>
                        <div class="top-margin">
                            <input type = "text" placeholder = "Total Question" onkeypress="return isNumberKey(event)" class = "text-sm w-100 p-2" id = "random" onkeyup="return random_que()">
                            <span id = "random_qno_err" class="color-red text-sm"> </span>
                        </div>
                        <div class="top-margin">
                            <select class="form-control filter_questions text-sm" id = "negative_marks_random" >                                        
                                <option value = -2>Select Negative Marking</option>
                                <option value = 0>None</option>
                                <option value = 0.25>25% Marks per wrong answer</option>
                                <option value = 0.50>50% Marks per wrong answer</option>
                                <option value = 0.75>75% Marks per wrong answer</option>
                                <option value = 1.00>100% Marks per wrong answer</option>
                            </select> 
                            <span id = "random_negative_err" class="color-red text-sm"> </span>
                        </div>
                        <select class="form-control filter_questions text-sm top-margin" id = "time_random" >                                        
                            <option value = -2>Exam Time</option>
                            <option value = 15>15 Minutes</option>
                            <option value = 20>20 Minutes</option>
                            <option value = 30>30 Minutes</option>
                            <option value = 45>45 Minutes</option>
                            <option value = 60>60 Minutes</option>
                            <option value = 75>75 Minutes</option>
                            <option value = 90>90 Minutes</option>
                        </select>
                        <span id = "random_time_err" class="color-red text-sm"> </span>

                        <select class = "form-control top-margin filter_questions text-sm" id = "passing_marks_random">
                            <option value = -2>Select Passing Marks</option>
                            <option value = 20>Minimum 20%</option>
                            <option value = 30>Minimum 30%</option>
                            <option value = 40>Minimum 40%</option>
                            <option value = 50>Minimum 50%</option>
                            <option value = 60>Minimum 60%</option>
                            <option value = 70>Minimum 70%</option>
                            <option value = 80>Minimum 80%</option>
                            <option value = 90>Minimum 90%</option>
                            <option value = 100>Minimum 100%</option>
                        </select>
                        <span id = "random_passing_err" class="color-red text-sm mt-2"> </span>
                        <span id = "random_err" class="color-red text-sm"> </span>
                       
                        <div class = "top-margin">
                            <button class = "btn btn-sm btn-warning w-100 float-right" type="button" onclick = "create_random_test()"> Create Random Test</button>
                        </div>
                        <!-- No of Questions -->
                        
                    </div>
                </div>
            </div>
            <!-- <div class=" card top-margin padding-xs-2">
                <b>Manual Selected Question:</b>
                <input type = "text" id = "manual_sel_question">
            </div> -->
        </div>
        
         <div class="col-md-8 pull-right top-margin">
            <div class = "text-right pb-3 container-fluid">
                <a href="admin_view_test.php" class="btn btn-warning text-right">Back to Show Test</a>
            </div>
            <div class="container-fluid ">               
                <div class="card shadow">
                    <div class="card-body bg-light ">
                        <div class="col-12  height-lg ">
                            <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info text-light">
                                <th>Subject</th>
                                <th>Easy</th>
                                <th>Medium</th>
                                <th>Hard</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id = "addQuesCount" class="text-center">
                            
                           
                        <!-- Table rows shows here -->
                        </tbody>
                        <tfoot id = "totalCount">
                            
                        </tfoot>
                    </table>
                        </div>
                    </div>
                </div>
            </div><!-- table end -->
                    
        </div>
        <!-- Successful test generation notification 
         <div class="modal fade" id="success_model" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body" id = "action_content">
                        Test Successfully Generated!
                    </div>                
                </div>
            </div>
        </div> -->

    <div class="modal fade" id="success_model" role="dialog">
	    <div class="modal-dialog modal-sm ">
	      <div class="modal-content">
	        <div class="modal-body p-4 ">
	        	<div class = "h1 text-center"><i class = "fa fa-check-circle text-success"></i></div>
	        	<p class = "text-center h6">Test Generated Successfully! </p>
	        </div>
	      </div>
	    </div>
	</div>
        <!-- Show Permissions -->
        <div class="modal fade" id="permissions" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class ="modal-header text-center">
                        <h5>Permissions</h5>
                    </div>
                    <div class="modal-body bg-info text-light" id = "permissions_content">
                        
                    </div>                
                </div>
            </div>
        </div>
     
    </section>

</div>
    <!-- External javascript -->
    <script type = "text/javascript" src="../js/lib/jquery-3.3.1.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-3.2.1.slim.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/jquery-1.9.1.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/popper.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/bootstrap.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>     
    <!-- User Defined Javascript -->
   
	<script type="text/javascript" src="../js/inputValidations.js"></script>
    <script type="text/javascript" src="../js/validations.js"></script>
    <script type="text/javascript" src="../js/question_paper.js"></script>
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>    
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>
 
  <script>
        

        function check_type(){
            if('<?php echo $_SESSION['userType']=="ADMIN"?>'){
                $("#success_model").modal('show');
                setTimeout(function(){ 
                    $("#success_model").modal('hide'); 
                    location.href="admin_view_test.php";
                }, 2000);
                //location.href="admin_view_test.php";
            }
            else{
                $("#success_model").modal('show');
                setTimeout(function(){ 
                    $("#success_model").modal('hide');
                    location.href="users_view_test.php"; 
                }, 2000);
                //location.href="users_view_test.php";
            }
        }
    </script>
</body>
</html>