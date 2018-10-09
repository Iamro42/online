<?php
	session_start();
	
	if(!empty($_SESSION) && (($_SESSION['userType']=="ADMIN"))){
    //echo $_SESSION['userId'];
    //echo $_SESSION['userType'];
	}
	else{
		echo "<script>location.href = '../../index.php' </script>;";
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
  <link rel="stylesheet" type="text/css" href="../css/media-queries.css">
    <script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
    
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


    <div class="wrapper" id ="index">
      <section class="margin-top-md">
          <div class = "top-margin ">
            <div class=" col-12">  
              <div class="container-fluid"><!-- table start -->
                <div class="pt-3"> 
                <select class= "form-control filter_questions col-md-3 float-left mr-3 p-1 text-sm" id = "question_subject" >
                    <option value = -2>Select Subject</option>
                    <option value = 0>Java</option>
                    <option value = 1>Php</option>
                </select>
                <select class = "form-control filter_questions col-md-3 float-left d-inline-block p-1 text-sm"  id = "que_priority" >
                    <option value = -2>Select Priority</option>
                    <option value = 1>Easy</option>
                    <option value = 2>Medium</option>
                    <option value = 3>High</option>
                  </select>
                <button type="button" class="btn btn-dark btn-sm bottom-margin-xs py-2 ml-2 col-md-1 reset">Reset</button>

                <button type="button" class="btn btn-warning btn-sm float-right bottom-margin-xs py-2 col-md-2" data-toggle="modal" data-target="#exampleModalLong">Add Question</button>
                </div>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><div class = "col-sm-12" >Sr.No</div></th>
                      <th><div class = "col-sm-12"> Questions</div></th>
                      <th><div class = "col-sm-12">Correct Answer</div></th>
                      <th><div class = "col-sm-12">Action</div></th>
                    </tr>
                  </thead>
                  <tbody id = "addQuesAns">
                  <!-- Table rows shows here -->
                  </tbody>
                </table>
                <nav class="float-right">
                  <ul class="pagination" id = "pagination">                    
                  </ul>

                   <ul class="pagination" id = "pagination_search">  
                  </ul>
                </nav>
              </div>
            </div>
          </div>
      </section>
    </div>

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header"><!-- modal header start -->
              <h5 class="modal-title " id="exampleModalLongTitle">Add Question</h5>
              <button type="button" onclick="clear_Add_New_Question()" class="close" data-dismiss="modal" >&times;</button>
          </div><!-- modal header end -->
          <div class="modal-body"><!-- modal body start -->
            <form id = "add_new_question_form">
              <div class="row margin-top-xs bottom-margin-xs">
                <div class="col-md-2 col-2 pt-3">
                  <span>Question:</span>
                </div>
                <!-- <div class = "col-md-7 ">&nbsp;</div> -->
                <div class = "col-md-10 col-10 float-right">
                  
                  
                  <select class= "form-control float-right w-50 mr-3 p-1 text-sm" id = "add_question_subject" >
                        <option value = -2>Select Subject</option>
                        <option value = 0>Java</option>
                        <option value = 1>Php</option>
                    </select>
                    <span class = "text-xs float-right mt-3 mr-3 color-red" id = "subjectErrAdd"></span>
                </div>
                <!-- <div class="col-md-6 col-6">
                  <form id="form1" runat="server">
                    <input type='file' id="imgInp" />             
                  </form>
                </div> -->
              
              </div>
              <textarea name="addEditorQuestion" id ="addEditorQuestion" onkeypress="checkEditor();"></textarea><!-- editor start -->
              <script>
                CKEDITOR.replace( 'addEditorQuestion',{height:100});            
              </script><!-- editor end -->
              <!-- Error to add Question -->
              <div style="height:24px">
                <span class = "text-xs color-red" id = "questionErrAdd"></span>
                <button type="button" class="btn btn-danger float-right bottom-margin-xs left-margin margin-top-xs" onclick = "removeOption()" id="removeOneField"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-success float-right bottom-margin-xs margin-top-xs text-md" onclick = "addNewOption()" id="addMoreFields"><i class="fa fa-plus"></i></button>
              </div>
              <!-- option1 -->
              <div class="row mt-5">
                <div class="col-md-2 col-2">
                  <span>Option1:</span>
                </div>
                <div class="col-md-10 col-9 input-group">
                  <input type="text" class="form-control" id="option_1"  aria-label="Text input with radio">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" id="correct_answer_add1" name="correct_answer_add" value="option1" >
                    </div>
                  </div>
                </div>
              </div>
              <!-- Error to add option 1 -->
              <span class = "text-xs color-red" id = "Option1ErrAdd"></span>
              <!-- option 2 -->
              <div class="row margin-top-xs ">
                <div class="col-md-2 col-2">
                  <span>Option2:</span>
                </div>
                <div class="col-md-10 col-9 input-group">
                  <input type="text" class="form-control" id="option_2"  aria-label="Text input with radio">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" id="correct_answer_add2" name="correct_answer_add" value="option2" >
                    </div>
                  </div>
                </div>
              </div>            
              <!-- Error to add option 2 -->
              <span class = "text-xs color-red" id = "Option2ErrAdd"></span>
              
              <!-- Option3 -->
              <div class="row margin-top-xs" id="option3">
                <div class="col-md-2 col-2">
                  <span>Option3:</span>
                </div>
                <div class="col-md-10 col-9 input-group">
                  <input type="text" class="form-control" id="option_3"  aria-label="Text input with radio">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                          <input type="radio" id="correct_answer_add3" name="correct_answer_add" value="option3">
                      </div>
                    </div>
                </div>
              </div>
              <span class = "text-xs color-red" id = "Option3ErrAdd"></span>
              <!-- Option4 -->
              <div class="row margin-top-xs " id="option4">
                <div class="col-md-2 col-2">
                  <span>Option4:</span>
                </div>
                <div class="col-md-10 col-9 input-group">
                  <input type="text" class="form-control" id="option_4"  aria-label="Text input with radio">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                          <input type="radio" id="correct_answer_add4" name="correct_answer_add" value="option4">
                      </div>
                    </div>
                </div>
              </div>
              <span class = "text-xs color-red" id = "Option4ErrAdd"></span>
              <span class = "text-xs color-red" id = "correct_option_add_err"></span>
              <div class="row margin-top-xs top-margin bottom-margin-xs">
                <div class="col-md-2 col-2">
                  <span>Explaination:</span>
                </div>
              </div>
              <textarea name="addEditorExplaination" id ="addEditorExplaination"></textarea><!-- editor start -->
              <script>
                CKEDITOR.replace( 'addEditorExplaination',{height:100});
              </script><!-- editor end -->

              <div class="row margin-top-xs">
                <div class="col-md-2 col-2">
                  <span>Priority:</span>
                </div>
                <div class="col-md-10 col-9">
                  <div class="custom-control custom-radio custom-control-inline ">
                    <input type="radio" id="easy" name="question_level_add" value = 1 class="custom-control-input ">
                    <label class="custom-control-label" for="easy">Easy</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="medium" name="question_level_add" value = 2 class="custom-control-input">
                    <label class="custom-control-label" for="medium">Medium</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="high" name="question_level_add" value = 3 class="custom-control-input">
                    <label class="custom-control-label" for="high">High</label>
                  </div>
                </div>                        
              </div>
              <!-- Error to add Question Priority -->
              <span class = "text-xs color-red" id = "priorityErrAdd"></span>
            </form>  
          </div><!-- modal body end -->
          <div class="modal-footer"><!-- modal footer start -->
            <button type="button" class="btn btn-primary" onclick = "addNewQuestion()">Add</button>
              <button type="button" class="btn btn-danger" onclick = "clear_Add_New_Question()" data-dismiss="modal">Close</button>
        </div><!-- modal footer end -->
      </div>
    </div>
  </div><!--exampleModalLong ends -->

  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">    
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
          <h5 class="modal-title" id="myModalHead">View Question</h5>
          <h5 class="modal-title questionEdit" id="questionEditMode">Question Edit Mode</h5>
                <button type="button" class="close" onclick = "clearViewQuestion()" data-dismiss="modal">&times;</button>             
            </div>
            <div class="modal-body">
          <div class="row margin-top-xs bottom-margin-xs">
            <div class="col-md-2 col-2">
              <span>Question:</span>
            </div>
          </div>
          <textarea name="viewEditorQuestion" id ="viewEditorQuestion"></textarea><!-- editor start -->
          <script>
            CKEDITOR.replace('viewEditorQuestion', {height: 100})
          </script><!-- editor end -->          
          <div style="height:24px">
            <span class = "text-xs color-red" id = "questionErrsubmit"></span>
            <button type="button" class="btn btn-success float-right bottom-margin-xs margin-top-xs text-md" onclick = "addNewOptionView()" id="addMoreFieldView"><i class="fa fa-plus"></i></button>
          </div>
          <div class="row mt-5">
            <div class="col-md-2 col-2">
              <span>Option1:</span>
            </div>
            <div class="col-md-10 col-9 input-group">
              <input type="text" class="form-control" id="option_view_1"  aria-label="Text input with checkbox">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" id="correct_answer_view" name="correct_answer_view" value="option1" >
                  </div>
                </div>
              <div class="input-group-prepend" id="option_View1">
                  <div class="input-group-text color-red">
                      <i class="fa fa-times"  aria-hidden="true" id="optionView1"></i>
                  </div>
                </div>
            </div>
          </div>
          <span class = "text-xs color-red" id = "option1ErrSubmit"></span>

          <div class="row margin-top-xs">
            <div class="col-md-2 col-2">
              <span>Option2:</span>
            </div>
            <div class="col-md-10 col-9 input-group">
              <input type="text" class="form-control" id="option_view_2" aria-label="Text input with checkbox">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" id="correct_answer_view" name="correct_answer_view" value="option2">
                  </div>
                </div>
                <div class="input-group-prepend" id="option_View2">
                  <div class="input-group-text color-red">
                      <i class="fa fa-times"  aria-hidden="true" id="optionView2"></i>
                  </div>
                </div>
            </div>
          </div>
          <span class = "text-xs color-red" id = "option2ErrSubmit"></span>
          <div class="row margin-top-xs" id = "option_view3">
            <div class="col-md-2 col-2">
              <span>Option3:</span>
            </div>
            <div class="col-md-10 col-9 input-group">
              <input type="text" class="form-control" id="option_view_3" aria-label="Text input with checkbox">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" id="correct_answer_view" name="correct_answer_view" value="option3">
                  </div>
                </div>
                <div class="input-group-prepend" id="option_View3">
                  <div class="input-group-text color-red">
                      <i class="fa fa-times"  aria-hidden="true" id="optionView3"></i>
                  </div>
                </div>
            </div>
          </div>
          <span class = "text-xs color-red" id = "option3ErrSubmit"></span>
          
          <div class="row margin-top-xs bottom-margin" id="option_view4" >
            <div class="col-md-2 col-2">
              <span>Option4:</span>
            </div>
            <div class="col-md-10 col-9 input-group">
              <input type="text" class="form-control" id="option_view_4" aria-label="Text input with checkbox">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                      <input type="radio" id="correct_answer_view" name="correct_answer_view" value="option4">
                  </div>
                </div>
                <div class="input-group-prepend" id="option_View4">
                  <div class="input-group-text color-red">
                      <i class="fa fa-times"  aria-hidden="true" id="optionView4"></i>
                  </div>
                </div>
            </div>
          </div>
          <span class = "text-xs color-red" id = "option4ErrSubmit"></span>         
          <span class = "text-xs color-red" id = "correct_option_view_err"></span>

          <div class="row margin-top-xs bottom-margin-xs">
            <div class="col-md-2 col-2">
              <span>Explaination:</span>
            </div>
          </div>
          <textarea name="viewEditorExplaination" id ="viewEditorExplaination"></textarea><!-- editor start -->
          <script>
            CKEDITOR.replace('viewEditorExplaination', {height:100})
          </script><!-- editor end -->
          <span class = "text-xs color-red" id = "explainationErrSubmit"></span>
          <div class="row margin-top-xs">
            <div class="col-md-2 col-2">
              <span>Priority:</span>
            </div>
            <div class="col-md-10 col-9">
              <div class="custom-control custom-radio custom-control-inline ">
                <input type="radio" id="question_level_view_view" name="question_level_view" value = 1 class="custom-control-input ">
                <label class="custom-control-label" for="question_level_view_view">Easy</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="question_level_view_medium" name="question_level_view" value = 2 class="custom-control-input">
                <label class="custom-control-label" for="question_level_view_medium">Medium</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="question_level_view_high" name="question_level_view" value = 3 class="custom-control-input">
                <label class="custom-control-label" for="question_level_view_high">High</label>
              </div>
            </div>
          </div>
          <span class = "text-xs color-red" id = "priorityErrSubmit"></span>
            </div><!-- Modal body ends -->

            <div class="modal-footer"><!-- Modal footer Starts-->
          <button type="button" class="btn btn-info" id ="submitQuestion">Submit</button>
              <button type="button" class="btn btn-info" id ="editQuestion">Edit</button>
                <button type="button" class="btn btn-danger" onclick="clearViewQuestion()" data-dismiss="modal" >Close</button>   
            </div><!-- modal footer ends-->
          </div>  
      </div>
  </div>  <!-- Edit Modal / myModal Ends -->

      <!-- Modal Box For Add Question -->
        <div class="modal fade" id="success_model" role="dialog">
          <div class="modal-dialog modal-sm ">
            <div class="modal-content">
              <div class="modal-body p-4 ">
                <div class = "h1 text-center"><i class = "fa fa-check-circle text-success"></i></div>
                <p class = "text-center h6 addQues">Question Added Successfully! </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Notification for question updated successfully -->
        <!-- <div class="modal fade" id="success_model_update" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body bg-success py-3" id = "action_content">
                        Test Successfully Generated!
                    </div>                
                </div>
            </div>
        </div> -->
        

     <!-- External javascript -->
    <script type = "text/javascript" src="../js/lib/jquery-3.3.1.js"></script>
    <script type = "text/javascript" src="../js/lib/jquery-3.2.1.slim.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/jquery-1.9.1.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/popper.min.js" ></script>
    <script type = "text/javascript" src="../js/lib/bootstrap.js"></script>
    
    <!-- User Defined Javascript -->    
	  <script type="text/javascript" src="../js/inputValidations.js"></script>
    <script type="text/javascript" src="../js/validations.js"></script>
    <script type="text/javascript" src="../js/queBank.js"></script>
    <script type="text/javascript" src="../js/users_permissions.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/vertical-responsive.js"></script>

    <script>
      selectValidation('#add_question_subject','#subjectErrAdd',"Please select Subject");
      checkEditor('addEditorQuestion','#questionErrAdd');
      checkRequired('#option_1','#Option1ErrAdd');
      checkRequired('#option_2','#Option2ErrAdd');
      checkRadio('#priorityErrAdd');  

      
      //checkEditor('viewEditorQuestion','#questionErrsubmit');
    </script>
</body>
</html>

