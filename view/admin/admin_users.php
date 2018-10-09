<?php
	session_start();
	
	if(!empty($_SESSION) && (($_SESSION['userType']=="ADMIN")) ){
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
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link rel="stylesheet" type="text/css" href="../css/lib/bootstrap.css">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
    <link rel="stylesheet" type="text/css" href="../css/media-queries.css">
</head>
<body>
  <header class="header clearfix fixed-position">
    <!-- <button type="button" class="toggle_sidenav margin-top-sm">
      <i class="fa fa-bars"></i>
    </button> -->
    <img src="../img/final%20logo.png" class="logo left-margin-sm margin-top-xs margin-logo">
    <div class ="profile"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="menu--icon fa fa-fw fa-user"></i></div>
     
        <div class="dropdown-menu dropdown-menu-right profile-box" style="width: 15rem;">
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
            <li class="menu--item" onclick = "signout();" title="Signout">
            <a class="menu--link" href="" >
                    <i class="menu--icon  fa fa-fw fa-power-off"></i>
                    <span class="menu--label">Sign Out</span>
                </a>
            </li>
        </ul>

        <button id="collapse_menu" class="collapse_menu">
            <i class="collapse_menu--icon  fa fa-fw"></i>
            <span class="collapse_menu--label">Recolher menu</span>
        </button>
    </nav>
    <!-- Wrapper starts here  -->
    <div class="wrapper p-all-1">
        <section class="mrt-6">
            <div class="col-md-12 p-xs-0">
            <div class = "col-12 p-0"> 
                <!-- Search Block -->
                <div class="col-8 d-inline-block float-left p-0 ">
                <button class = "btn btn-sm btn-info py-2 px-3 mt-3 fa fa-search" title = "Click to Search Users" id = "fa-search"> Search 
                </button>
                <button class = "btn btn-sm btn-success py-2 px-4 mt-3 fa fa-filter" title = "Click to Filter Users" id = "fa-filter"> Filter 
                </button>           
                    
                    <div id = "search_by_users" class = "">
                    <form id ="reset_form">
                        <select class = "filter_questions mt-3 mr-2 pb-1 w-25 d-inline float-left"  id = "candidate_filter">
                            <option value = "fname">Name</option>
                            <option value = "email">Email</option>
                            <option value = "mobile">Mobile no.</option>
                            <option value = "date">Create Date</option>                       
                        </select>    
                        <input type = "text"    id = "filter" class = "w-50 p-1 bottom-margin-xs mt-3 mr-2 float-left">
                    </form>    
                        <div class = "by_created ">
                        <form id = "by_date" class = "d-inline">
                            <input type="text" class="d-inline mt-3 px-0 py-1 w-25 text-sm float-left" placeholder = "From" id = "by_from_date">
                            <input type="text" class="px-0 py-1 mt-3 w-25 text-sm" placeholder = "To" id = "by_to_date">
                        </form>
                            <button class = "d-inline btn btn-sm btn-success py-1  my-3  mr-1" onclick = "search_by_date()" >Search</button>
                            <button class = "btn btn-sm btn-dark py-1  my-3  mr-1" onclick = "reset_date()" >Reset</button>                            
                        </div>
                    
                        <button class = "btn btn-sm btn-success py-1 mt-3 mr-1 search_info" id = "btn_search" onclick = "search_info()" >Search</button>
                        <button class = "btn btn-sm btn-dark py-1  mt-3  mr-1 reset_out" onclick = "reset_info()" >Reset</button>
                        
                    </div>

                    <div id = "filter_by_users" class = "">
                        <select class = "filter_users my-3 mr-2 pb-1 w-25 d-inline float-left"  id = "user_filter">
                            <option value = "-2"> Select User Type</option>
                            <option value = "CANDIDATE"> Candidate</option>
                            <option value = "QUESTION_PAPER"> Question Paper Generator</option>
                            <option value = "QUESTION_BANK"> Question Bank Creator</option>
                            <option value = "REGISTRAR"> Registrar</option>
                            <option value = "EMPLOYEE"> Employee</option>
                            <option value = "STUDENT"> Students</option>
                        </select>
                        <!-- <input type = "text" placeholder = "Search by User Name" class = "w-50 p-1 bottom-margin-xs mt-3 mr-2 d-inline float-left">
                        <button class = "btn btn-sm btn-success py-1 mt-3 mr-1" >Search</button>
                        <button class = "btn btn-sm btn-dark py-1 mt-3" id = "reset_fields" >Reset</button> -->
                    </div>


                </div>
                <div class = " col-4 float-right d-inline-block pr-0">
                    <button type="button" class="btn btn-sm btn-warning float-right bottom-margin-xs mt-3" onclick="window.location.href='../admin/admin_registration.php'" >Add new User</button>
                </div>
            </div>
                <!-- table start -->
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr class = "font-weight-bold">
                      <td><div class = "col-sm-12">SR.NO</div></td>
                      <td><div class = "col-sm-12">User Name</div></td>
                      <td><div class = "col-sm-12">E-Mail</div></td>
                      <td><div class = "col-sm-12">Mobile No</div></td>
                      <td><div class = "col-sm-12">User Type</div></td>
                      <td><div class = "col-sm-12">Action</div></td>
                    </tr>
                  </thead>
                  <tbody id = "add_users">
                  <!-- Table rows shows here -->
                  </tbody>
                </table>
                <!-- Table End -->
                <nav class="float-right">
                  <ul class="pagination" id = "pagination">
                  </ul>
                </nav>
              </div>
        </section>
    </div>
    <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header login-bg text-light">
                <h5 class="modal-title">User Information</h5>
                <button type="button" class="text-light close close-model" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id = "action_content">
            <form id = "users_info">
                <div class = "row px-3">
                    <div class = "mb-2 p-1 col-md-6">
                        <div> First Name </div>
                        <input type = "text" id = "first_name" placeholder = "First Name " class="form-control bg-trans-white text-colour">
                        <span class = "text-xs color-red" id = "editFirstNameError"></span>                    
                    </div>
                    <div class = "mb-2 p-1 col-md-6 float-right">   
                        <div> Last Name </div>             
                        <input type = "text" id = "last_name" placeholder="Last Name" class="form-control bg-trans-white text-colour">
                        <span class = "text-xs color-red" id = "editLastNameError"></span>
                    </div>
                </div>    
                <div class = "row px-3">
                    <div class = "mb-2 p-1 col-md-6">
                    <div> Mobile Number</div>    
                        <input type = "text" id = "mobile_no" placeholder="Mobile Number" class="form-control bg-trans-white text-colour">
                        <span class = "text-xs color-red" id = "editMobileNoError"></span>
                    </div>
                    <div class = "mb-2 p-1 col-md-6 float-right">
                    <div> Email - id </div>    
                        <input type = "text" id = "email_show" placeholder="Email-id" class="form-control bg-trans-gray text-colour" disabled >
                        <span class = "text-xs color-red" id = "editEmailError"></span>
                    </div>
                </div>
                <!-- User type -->
                <div class = "mb-2 p-1"> 
                    <div class = "mb-2"> User Type</div>    
                    <select class = "form-control text-sm" id = "user_type">
                        <option value = "CANDIDATE">CANDIDATE</option>
                        <option vlaue = "QUESTION_PAPER">QUESTION_PAPER</option>
                        <option vlaue = "QUESTION_BANK">QUESTION_BANK</option>
                        <option vlaue = "REGISTRAR">REGISTRAR</option>
                        <option vlaue = "STUDENT">STUDENT</option>
                        <option vlaue = "EMPLOYEE">EMPLOYEE</option>
                    </select>
                    <span class = "text-xs color-red" id = "editUserTypeError"></span>
                </div>
                <!-- User Status -->
                <div class = "mb-2 p-1">
                    <div class = "col-4 p-0 d-inline-block">
                        <label>User Status :</label>
                    </div>
                    <div class = "col-8 d-inline-block float-right">
                        <input type="radio"  name="status" value = "1" class = "mr-1" ><label class = "mx-1">Active</label>                       
                        <input type="radio"  name="status" value = "2" class = "mr-1" > <label class = "mx-1">Inactive</label>                       
                    </div> 
                    <span class = "text-xs color-red" id = "editStatusError"></span>
                </div>
                <!-- Date Created -->
                <div class = "mb-2 p-1">   
                <div class = "col-4 p-0 d-inline-block">
                        <label>Created on :</label>
                    </div>
                    <div class = "col-8 d-inline-block float-right">
                    <label class = "font-weight-bold created_on"></label>     
                    </div> 
                    </div>
                <!-- User Permissions -->
                <div class = "mb-2 p-1" id = "user_permissions">
                    <div class = "col-4 p-0 d-inline-block">
                        <label>User Permissions :</label>
                    </div>
                    <div class = "col-8 float-right">					
						<input type = "checkbox" name='check' class = "check generate_test1" value= "GENERATE_TEST">Generate Tests<br>
						<input type = "checkbox" name='check' class = "check create_qb" value ="CREATE_QUESTION_BANK">Create Queston Bank<br>										
						<input type = "checkbox" name='check' class = "check create_user" value="CREATE_USER">Create Users<br>
						<input type = "checkbox" name='check' class = "check access_qb" value= "ACCESS_QUESTION_BANK">Access Queston Bank<br>
						<input type = "checkbox" name='check' class = "check view_result" value ="VIEW_RESULT">View Results<br>				
                    </div>
                    <span class = "text-xs color-red" id = "editPermissionError"></span>
                </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm close-model" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id = "update_user_info">Update</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Customized Alert Box -->
    <!-- <div class="modal fade bd-example-modal-sm" id="alert_box" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="width: 15rem;">
            <div class="modal-content">
                
                <div class="modal-body my-2" >
                    <div class = "p-3" id = "alert_content"></div>
                </div>
                
            </div>
        </div>
    </div> -->
    <div class="modal fade" id="alert_box" role="dialog">
        <div class="modal-dialog modal-sm ">
            <div class="modal-content">
                <div class="modal-body p-4 ">
                <div class = "h1 text-center"><i class = "fa fa-check-circle text-success"></i></div>
                <p class = "text-center h6 userInfo">User Removed Successfully! </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- External Offline Javascript -->
    <script type = "text/javascript" src="../js/lib/jquery-3.3.1.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-3.2.1.slim.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/jquery-1.9.1.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/popper.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/bootstrap.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-ui.js"></script> 
    
    <!-- User Defined Javascript -->    
    <script type="text/javascript" src="../js/inputValidations.js"></script>
    <script type="text/javascript" src="../js/validations.js"></script>
    <script type="text/javascript" src="../js/admin_users.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>
    <script>
        checkRequired('#subject_name','#subjectNameError');
       
        
    </script>
</body>
</html>
