<?php
	session_start();
	
	if(isset($_SESSION) && (($_SESSION['userType']=="QUESTION_PAPER") || ($_SESSION['userType']=="QUESTION_BANK") || ($_SESSION['userType']=="REGISTRAR") || ($_SESSION['userType']=="ADMIN"))){
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" type="text/css" href="../css/demo.css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/vertical-responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
  <link rel="stylesheet" type="text/css" href="../css/mobile.css">
  <link rel="stylesheet" type="text/css" href="../css/media-queries.css">
  <style>
      .fs-16{
        font-size: 16px;
      }
  </style>
</head>

<body>
    <!-- onkeypress="myFunction(event)" oncontextmenu="return false" onload="restrict()" onblur = "restrict_user()" -->

   <header class="header clearfix fixed-position">

    <img src="../img/final%20logo.png" class="logo left-margin-sm margin-top-xs margin-logo">
    <div class ="profile"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="menu--icon fa fa-fw fa-user"></i></div>
     
        <div class="dropdown-menu dropdown-menu-right" style="width: 15rem;">
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
    <!-- <div class = "col-md-3 d-inline-block mrt-9 pr-0">
        <div class="container-fluid">
            
        </div>
    </div> -->
    <div>
    <section class = "mrt-9 pull-left col-md-3 pr-0 position-fixed">
        <div class="container-fluid">
            <div class="card my-2 p-0 col-md-12 bg-light">
                <div class="card-body">  
                    <button class = "btn btn-danger  text-sm p-2 px-3 float-left text-center w-100 " onclick="window.location = '../admin/index.php'"><i class = "fa text-sm fa-home fs-16 mr-2 text-light"></i>Back to home</button>
                </div>
            </div>
            <div class="card my-2 p-0 col-md-12 bg-light">  
                <div class="card-body">
                    <button class="card-title btn btn-secondary w-100 text-light text-center open_filter"><i class = "fa fa-filter pr-1"></i>Filter Results</button>
                    <div class="filter_result_data">
                            <!-- Filter by Test code -->
                        <form id = "clear_result_form" action = "../../model/ExportModel.php" method = "POST">

                            <!-- Search by college name -->
                            <select class = "text-sm form-control my-2" id = "by_college_name" onchange = "filter();">
                                <option value = "-2">Select College Name</option>
<!--                                <option>JIT Nagpur</option>-->
<!--                                <option>NUVA College</option>-->
<!--                                <option>NIT College</option>-->
                            </select>
                            <!-- Search by Test codes -->
                            <select class = "text-sm form-control mt-3" id = "by_testcode" onchange = "filter();">
                                <option>Select Paper Set</option>
                                <option>QPS/005/2</option>
                                <option>QPS/004/12</option>
                                <option>QPS/004/15</option>
                            </select>
                            <!-- <input type="text" class="w-100 mt-2 p-1" placeholder = "Search by Test Code" id = "by_testcode">
                            <span class = "text-xs color-red" id = "testcodeErrAdd"></span>  -->
                                <!-- Search by Username -->
                            <input type="text" class="w-100 p-1 mt-3" placeholder = "Search by First name" id = "by_username" onkeyup = "filter();"> 
                            <span class = "text-xs color-red" id = "usernameErrAdd"></span>
                            
                            
                            
                            <!-- Search by Date -->
                            <div class = "mt-2 text-center">
                                <label class="h6 "> Search By Date</label><br>  
                                <div class="col-md-6 d-inline">From Date</div> <div class="col-md-6 float-right">To Date</div>             
                                <input type="text" class="w-100 d-inline px-0 py-1 text-xs float-left col-6" placeholder = "From Date" id = "by_from_date">
                                <input type="text" class="w-100 col-6 px-0 py-1 text-xs" placeholder = "To Date" id = "by_to_date">
                            </div>
                        </form>
                        <span class = "text-xs color-red" id = "dateErrAdd"></span>
                        <button class="btn btn-primary w-100 text-center mt-3" onclick = "filter();" > Search </button>
                        <button class="btn btn-info w-100 text-center mt-2" onclick = "downloadPDF();" > Download As PDF </button>
                        <!-- <input type = "submit" class="btn btn-info w-100 text-center mt-2" value = "Download As PDF"> -->
                        <button class="btn btn-secondary w-100 text-center mt-2" onclick = "reset_fields();" > Reset </button>                               
                    </div>
                </div> 
            </div>
        </div>
    </section>


    <section class = "mrt-9 pull-right col-md-9 px-0">
        <div class="container-fluid">
            <div class="card my-2 p-2 col-md-12 bg-light">  
                <div class="card-body">
                    <h5 class="card-title text-light text-center p-2 bg-info">Result</h5>
                    <table class="table table-striped table-light" >
                        <thead>
                            <tr class="text-xs text-center">
                                <th scope="column">SR. NO.</th>
                                <th scope="column">User Name</th>
                                <th scope="column">Name</th>
                                <th scope="column">Test Code</th>
                                <!-- <th scope="column">Total Question</th> -->
                                <!-- <th scope="column">Total Marks</th> -->
                                <!--<th scope="column">Attempted Question</th>
                                <th scope="column">Correct Answers</th> -->
                                <!-- <th scope="column">Obtain Marks</th> -->
                                <th scope="column">Passing Percent</th>
                                <th scope="column">Obtain Percent</th>
                                <th scope="column">Result</th>
                                <th scope="column">Date</th>
                                <th scpope = "column"> Action </th>
                            </tr>
                        </thead>
                        <tbody id="result">
                                
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </section>

        <section class = "mrt-9 pull-right col-md-9 px-0" id = "result_page">
            <div class="container-fluid">
                <div class="card my-2 p-2 col-md-12 bg-light">
                    <div class="card-body">
                        <!-- Header -->
                        <h3 id = "college_name" style="text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px;">
                            College Name
                        </h3>


                        <div style="margin-bottom: 20px; width: 100%; border-bottom: 1px #000">
                            <div style="width: 50%; float: left; margin-bottom: 20px;">
                                <!-- Report Date - Time -->
                                <div>
                                    Report Date : <span id="report_date">28/09/2018</span>
                                </div>
                                <div>
                                    Report Time : <span id="report_time">28/09/2018</span>
                                </div>
                                <div>
                                    Total Marks : <span id="total_marks">28/09/2018</span>
                                </div>
                            </div>

                            <div style="width: 40%; float: right;">
                                <!-- Exam Date Time -->
                                <div >
                                    Exam Date : <span id="exam_date">28/09/2018</span>
                                </div>
                                <div>
                                    Exam Time : <span id="exam_time"> 00:30:00 </span>
                                </div>
                                <!-- <div>
                                    Exam Duration : <span id="exam_duration"> 00:30:00 </span>
                                </div> -->
                                <!-- Total Marks -->
                            </div>

                        </div>
                    
                        <!-- Body -->
                        <table style="margin-bottom: 20px;" border="1" align="center" width="100%">
                            <thead>
                            <tr class="text-xs text-center">
                                <th scope="column">SR. NO.</th>
                                <th scope="column">Email</th>
                                <th scope="column">Name</th>
                                <th scope="column">Obtain Marks</th>
                                <th scope="column">Obtain Percent</th>
                                <th scope="column">Result</th>
                            </tr>
                            </thead>
                            <tbody id="result_set">

                            </tbody>
                        </table>
                        <!-- Footer -->
                        <hr>

                        <div class ="row" style="float: left; margin-top: 10px;">                            
                            <div class="col-12 float-left">
                                Minimum Marks To Pass : <span id = "min_marks"> 0 Marks</span>
                            </div>
                            <div class="col-12 float-left">
                                Negative Marks : <span id = "negative_mark">No Negative Marks </span>
                            </div>                                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="view_more_info" tabindex="-1" role="dialog" aria-labelledby="view_more_info" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header login-bg text-white">
                    <h5 class="modal-title" id="qp_title">Question Paper Id</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light" id = "action_content"> 
                    
                    <div class= "col-12 p-0">       
                        <div class="my-3 p-0" >
                            <table class="table table-bordered table-light">
                                
                                <tbody id = "table_info">
                                </tbody>
                            </table>        
                        </div>                        
                    </div>
                    <button class="btn btn-light float-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div> 
    </div>
    
    <!-- Show Modal -->
    <!-- Modal -->
    <!-- Modal -->
    <!-- if User candidate wo has permission to see results this model will be open for them on page load -->
    <div class="modal fade" id="action_model" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action_modeltitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id = "action_content">
                    <input type = "text" placeholder = "Enter Test Code" id = "test_code" class="w-100 p-1 form-control bg-trans-white text-colour"><br>
                    <span class = "text-xs color-red" id = "testCodeErr">  </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id = "show_modal_code_result">Show Result</button>
                </div>
            </div>
        </div>
    </div>
        

    <script type = "text/javascript" src="../js/lib/jquery-3.3.1.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-3.2.1.slim.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/jquery-1.9.1.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/popper.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/bootstrap.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://docraptor.com/docraptor-1.0.0.js"></script>

   
  
    <script type="text/javascript" src="../js/inputValidations.js"></script>
    <script type="text/javascript" src="../js/validations.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/result.js"></script>
    <script>
        checkRequired('#test_code','#testCodeErr');
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
