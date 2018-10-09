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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/media-queries.css"> -->
    
    
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
    <div class="wrapper">
        <section class="margin-top-md">
        
           <form id = "form_view_test">
                <select class = "form-control filter_questions col-md-3 float-left d-inline-block mt-3 mr-2 p-1 text-sm"  id = "view_test_filter" >
                    <option value = -2>Filter Tests By</option>
                    <option value = "sub_name">Subject Name</option>
                    <option value = "date">Date</option>
                </select>
                <select class= "form-control filter_questions col-md-3 float-left  mt-3 p-1 text-sm" id = "question_subject" >
                    <option value = -2>Select Subject</option>
                    <option value = 0>Java</option>
                    <option value = 1>Php</option>
                </select>
            </form>
                <div class = "by_created ">
                    <form id = "by_date" class = "d-inline">
                        <input type="text" class="d-inline mt-3 mr-2 px-0 py-1 w-20 float-left" placeholder = "From" id = "by_from_date">
                        <input type="text" class="px-0 py-1 mt-3 w-20 " placeholder = "To" id = "by_to_date">
                    </form>
                        <button class = "d-inline btn btn-sm btn-success py-1  my-3  mr-1" onclick = "search_by_date()" >Search</button>
                        <button class = "btn btn-sm btn-dark py-1  my-3  mr-1" onclick = "reset_date()" >Reset</button>                            
                </div>
               
            
            <button type="button" class="btn btn-dark btn-sm bottom-margin-xs py-2 mt-3 ml-2 col-md-1 reset">Reset</button>

            
        
            <button type="button" class="btn btn-warning btn-sm float-right  mt-3" onclick = "window.location.href = '../admin/admin_add_test.php';" >Generate New Test</button><br>
            <div class = "mt-2 ">
                <span class = "top-margin text-muted h5">Subject Wise Tests</span>
                <div class="container-fluid p-3 mt-3 border d-inline-block" id="show_question_paper">
                    <h4 class = "text-center text-danger sub_not_found">No Test Found</h4>
                </div>
            </div>
            <div class = "top-margin ">  
                <span class = "h5 text-muted">Random Question Test</span>  
                <div class="container-fluid p-3 mt-3 border d-inline-block" id="show_question_paper_random">
                    <h4 class = "text-center text-danger rndm_not_found">No Test Found</h4>
                </div>
            </div>
        </section>
        <div class="modal fade" id="action_model" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title " id="qp_title">Question Paper Id</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-dark" id = "action_content"> 
                        <div class= "col-12 p-0">       
                            <div class="my-3 p-0" >
                                <table class="table table-bordered table-dark">
                                    <thead>
                                        <tr>                                
                                            <th scope="col">Title</th>
                                            <th scope="col">Info</th>
                                        </tr>
                                    </thead>
                                    <tbody id = "table_info">
                                        <tr>
                                            <td>Subject :</td>
                                            <td><span id = "qp_subject"><!-- Subject of Question PAper set will be here--></span></td>
                                        </tr>

                                        <tr>
                                            <td>Total Questions :</td>
                                            <td><span id = "qp_total_question"> <!-- Total number of questions in paper set are here --></span></td>
                                        </tr>

                                        <tr>
                                            <td>Low :</td>
                                            <td><span id = "qp_low_question"><!-- Questions of low priority will be here --></span></td>
                                        </tr>

                                        <tr>
                                            <td>Medium :</td>
                                            <td><span id = "qp_medium_question"><!-- Question of medium priority will be here --> </span></td>
                                        </tr>

                                        <tr>
                                            <td>High :</td>
                                            <td><span id = "qp_high_question"><!-- Subject of Question PAper set will be here--></span></td>
                                        </tr>

                                        <tr>
                                            <td>Negative marking :</td>
                                            <td><span id = "qp_negative_marks"><!-- Subject of Question PAper set will be here--></span></td>
                                        </tr>

                                        <tr>
                                            <td>Created on :</td>
                                            <td><span id = "qp_created_date"><!-- Subject of Question PAper set will be here--></span></td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>    
                        </div>
                        <button class="btn btn-warning float-right" data-dismiss="modal">Close</button>
                    </div>
                </div>        
            </div>
        </div>
    
        
        <div class="modal fade" id="notification" role="dialog">
	    <div class="modal-dialog modal-sm ">
	      <div class="modal-content">
	        <div class="modal-body p-4 ">
	        	<div class = "h1 text-center"><i class = "fa fa-check-circle text-success"></i></div>
	        	<p class = "text-center h6">Test Generated Successfully! </p>
	        </div>
	      </div>
	    </div>
	</div>
    </div>

        <!-- External Scripts -->
    <script type = "text/javascript" src="../js/lib/jquery-3.3.1.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-3.2.1.slim.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/jquery-1.9.1.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/popper.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/bootstrap.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-ui.js"></script> 
      <!-- User Defined Script -->
     
   
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/question_paper_dashboard.js"></script>
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>
    <script>
    
    
</script>

    </body>

</html>