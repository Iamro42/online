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
  <link rel="stylesheet" type="text/css" href="../css/lib/bootstrap.css">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile.css">
    <link rel="stylesheet" type="text/css" href="../css/media-queries.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
   
    
</head>

<body>

  <header class="header clearfix fixed-position">
     <button type="button" id="toggleMenu" class="toggle_sidenav margin-top-sm">
      <i class="fa fa-bars"></i>
    </button>
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
    <div class="wrapper">
        <section class="margin-top-md">
            <div class="col-md-12 at">
                <div class = "col-12 p-0">
                    <div class="col-6 d-inline-block float-left p-0 ">
                        <input type = "text" id ="search_by_subject"  placeholder = "Search by Subject Name" class = "w-50 p-1 bottom-margin-xs text-sm mt-3">
                        <button class = "btn btn-sm btn-success py-1"  onclick ="search_subject()">Search</button>
                        <button class = "btn btn-sm btn-dark py-1" id = "reset_fields" >Reset</button>
                    </div>
                    <div class = " col-4 float-right d-inline-block pr-0">
                        <button type="button" class="btn btn-sm btn-warning float-right bottom-margin-xs mt-3" data-toggle="modal" data-target="#add_subject" >Add new Subject</button>
                    </div>
                </div>
                <!-- table start -->
                <table class="table table-bordered table-striped" >
                  <thead>
                    <tr class = "font-weight-bold">
                      <td>Sr.No</td>
                      <td>Subject Name</td>
                    </tr>
                  </thead>
                  <tbody id = "add_subjects">
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
    

    <!-- Duplicate -->
    <div class="modal fade" id="add_subject" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add New Subject</h5>
                <button type="button" class="close" data-dismiss="modal" onclick = "return reset()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-4" id = "action_content">
            <form>
                <input type = "text" id = "subject_name" placeholder = "Enter Subject Name" class="p-1 form-control text-md w-100">
                <span class = "text-xs color-red" id = "subjectNameError"></span>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick = "return reset()" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="add_sub" onclick = "add_new_subject()">Add</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Edit Subject -->
    <div class="modal fade" id="edit_subject" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered model-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add New Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-4" id = "action_content">
                <input type = "text" id = "edit_subject_name" class="p-1 w-100">
                <span class = "text-xs color-red" id = "editSubjectError"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id = "edit_subject_btn">Update</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Customized Alert Box -->
    <div class="modal fade bd-example-modal-sm" id="alert_box" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
               
            </div>
            <div class="modal-body my-2" >
                <div class = "p-3" id = "alert_content"></div>
            </div>
            <div class="modal-footer">
                
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
     <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    
    <!-- User Defined Javascript -->    
    <script type="text/javascript" src="../js/inputValidations.js"></script>
    <script type="text/javascript" src="../js/validations.js"></script>
    <script type="text/javascript" src="../js/admin_subject.js"></script>
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>
    <script>
        checkRequired('#subject_name','#subjectNameError');
        // function openNav() {
        //     var x = document.getElementById("mySidenav");
        //     if (x.style.width === "0px") {
        //         x.style.width = "300px";
        //     } else {
        //         x.style.width = "0px";
        //     }
        // }
    </script>
</body>
</html>
