<?php
	session_start();
	
	if( !empty($_SESSION) && (($_SESSION['userType']=="ADMIN")) ){
    //echo $_SESSION['userId'];
    //echo $_SESSION['userType'];
	}
	else{
		echo "<script>location.href = 'index.php'</script>;";
	}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Tantransh - Question Paper</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/lib/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
    <link rel="stylesheet" type="text/css" href="../css/media-queries.css">
    <style>
        .bg-grad{
            background: linear-gradient(to bottom right, #17a2b8, #12bdbc);
        }  
        .bg-grad-2{
            background: linear-gradient(to bottom right, #d23f18, #bd12af);
        }      
        .question, .users, .tests{
            height:200px;
        }
        .more{
            position:absolute;
            bottom:0;
            right:0;
            margin: 0 15px 10px 0px;
        }
    </style>
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
            <a class="menu--link" href="../admin/index.php" title="Admin Home">
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
            <li class="menu--item"  title="Signout">
            <a class="menu--link" href="#" onclick = "signout();" >
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



    <div class="wrapper p-all-1">
        <section class=" my-3 mrt-9 text-white">
                <!-- Tests -->
                <div class="col-md-4 col-sm-6 col-xs-12 top-margin  d-inline-block float-left my-4" id = "tests" >
                    <div class="card shadow tests-c">
                        <div class="card-body bg-grad ">
                            
                            <!-- <div class="height-lg " id = "test-1">
                                <div class="text-white text-center display-4"><span class="fa fa-fw fa-clipboard "></span><h5>Tests</h5></div>
                            </div> -->

                            <!-- Second Part -->
                            <div class="height-lg " id = "test-1">
                                <div class="col-5 p-0 display-4 d-inline-block text-left"><span class="fa fa-fw fa-clipboard "></span><h6 class = "text-md ml-3">Tests</h6></div>
                                <div class ="col-7 p-0 mt-4 h4 float-right text-center">Total<span class = "ml-2 h3" id = "total_tests">34</span></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Questions -->
                <div class="col-md-4 col-sm-6 col-xs-12 top-margin h-100 d-inline-block float-left my-4" id = "questions">
                    <div class="card shadow questions-c">
                        <div class="card-body bg-grad"> 

                            
                            <!-- <div class="height-lg" id = "ques-1">
                                <div class="text-white text-center display-4"><span class="fa fa-fw fa-question-circle-o "></span><h5>Questions</h5></div>
                            </div> -->

                            <!-- Second Part -->
                            <div class="height-lg" id = "ques-1">
                                <div class="col-5 p-0 display-4 d-inline-block text-left"><span class="fa fa-fw fa-question-circle-o "></span><h6 class = "text-md">Questions</h6></div>
                                <div class ="col-7 p-0 mt-4 h4 float-right text-center">Total<span class = "ml-2 h3" id = "total_question">34</span></div>
                            </div>
                        </div>                       
                    </div>                    
                </div>
                <!-- Users -->
                <div class="col-md-4 col-sm-6 col-xs-12 top-margin d-inline-block float-left my-4" id = "users">
                    <div class="card shadow users-c">
                        <div class="card-body bg-grad ">
                            
                            <!-- <div class="height-lg" id = "user-1">
                                <div class="text-white text-center display-4"><span class="fa fa-fw fa-user "></span><h5>Users</h5></div>
                            </div> -->

                            <!-- Second part -->
                            <div class="height-lg" id = "user-1">
                                <div class="col-5 p-0 display-4 d-inline-block text-left"><span class="fa fa-fw fa-user "></span><h6 class = "text-md ml-3">Users</h6></div>
                                <div class ="col-7 p-0 mt-4 h4 float-right text-center">Total<span class = "ml-2 h3" id = "total_users">34</span></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- subjects -->
                <div class="col-md-4 col-sm-6 col-xs-12 top-margin d-inline-block float-left my-4" id = "subjects">
                    <div class="card shadow subjects-c">
                        <div class="card-body bg-grad ">
                            
                            <!-- <div class="height-lg" id = "subject-1">
                                <div class="text-white text-center display-4"><span class="fa fa-fw fa-book "></span><h5>Subjects</h5></div>
                            </div> -->

                            <!-- Second part -->
                            <div class="height-lg" id = "subject-1">
                                <div class="col-5 p-0 display-4 d-inline-block text-left"><span class="fa fa-fw fa-book "></span><h6 class = "text-md">Subjects</h6></div>
                                <div class ="col-7 p-0 mt-4 h4 float-right text-center">Total<span class = "ml-2 h3" id = "total_subjects">34</span></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Results -->
                <div class="col-md-4 col-sm-6 col-xs-12 top-margin d-inline-block float-left my-4" id = "result">
                    <div class="card shadow result-c">
                        <div class="card-body bg-grad ">
                            
                            <!-- <div class="height-lg" id = "result-1">
                                <div class="text-white text-center display-4"><span class="fa fa-fw fa-user "></span><h5>Results</h5></div>
                            </div> -->

                            <!-- Second part -->
                            <div class="height-lg" id = "result-1">
                                <div class="col-5 p-0 display-4 d-inline-block text-left"><span class="fa fa-fw fa-user "></span><h6 class = "text-md ml-1">Results</h6></div>
                                <div class ="col-7 p-0 mt-4 h4 float-right text-center">Total<span class = "ml-2 h3" id = "total_results">34</span></div>
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
     <script type="text/javascript" src="../js/lib/bootstrap.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
	<!-- <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    
    
  	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    
    
    <!-- User Defined Javascript -->    
    
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>
    <script type="text/javascript" src="../js/admin.js"></script>

    <script>
    $(".question").hide();
    $( ".fa-question-circle-o" ).click(function() {    
        $(".question").slideToggle("slow");
    });

    // function openNav() {
    //         var x = document.getElementById("mySidenav");
    //         if (x.style.width === "0px") {
    //             x.style.width = "300px";
    //         } else {
    //             x.style.width = "0px";
    //         }
    //     }
</script>
</body>
</html>
