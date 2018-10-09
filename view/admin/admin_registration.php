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
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1  shrink-to-fit=no">
	<!-- online bootstrap implementation -->
	<link rel="stylesheet" type="text/css" href="../css/lib/bootstrap.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
	
	<!-- external user created css -->
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/desktop.css">
	<link rel="stylesheet" type="text/css" href="../css/mobile.css">
	<style>
	
	input {
  	  text-transform: capitalize;
	}
	#email_id{
		text-transform: lowercase;
	}
</style>
</head>
<body class="login-bg">	
	<div class="container-reg margin-bottom-sm1">
		<div class=" shadow padding-xs box-colour">
			<div class="text-center"><img src="../img/final%20logo.png" width="160px" height="65px"></div><hr>
			<h6 class="text-center font-weight-bold bg-info text-light py-2 my-3">Candidate Registration Form</h6>
					<form id = "myRegistration">
	  						<div class="form-row padding-sm">
							  <!-- First Name -->
	    						<div class="col">
	      							<input type="text" class="form-control bg-trans-white text-colour" placeholder="First name *" id = "first_name">
									<span class = "text-xs color-red" id = "firstNameErr"></span>
								</div>
								<!-- Last Name -->
	   						 	<div class="col">
	     						    <input type="text" class="form-control bg-trans-white text-colour" placeholder="Last name *" id = "last_name">
									<span class = "text-xs color-red" id = "lastNameErr"></span>
								</div>									
	  						</div>
							<div class="form-row padding-sm">
							  <!-- Email-id -->
	    						<div class="col">
									<input type="text" class="form-control bg-trans-white text-colour" placeholder="Email *" onblur = "checkMailStatus()" id = "email_id">
									<span class = "text-xs color-red" id = "emailErr"></span>
								</div>
								<!-- Mobile Number -->
	    						<div class="col">
									<input type="text" class="form-control bg-trans-white text-colour" maxlength="15" onblur = "mobileLength()"  placeholder="Mobile No *" id = "mobile_no">
									<span class = "text-xs color-red" id = "mobileErr"></span>
								</div>																
	  						</div>
							<div class="form-row padding-sm">							  
								<!-- Password -->
								<div class="col">
	     						    <input type="password" class="form-control bg-trans-white text-colour" placeholder="Password *" id = "password" onblur="passwordLength()">
									<span class = "text-xs color-red" id = "passwordErr"></span>
								</div>	
								<!-- Confirm Password -->
	   						 	<div class="col">
	     						    <input type="password" class="form-control bg-trans-white text-colour" placeholder="Confirm Password *" id = "cnf_password" onblur = "checkConfirmPass()">
									<span class = "text-xs color-red" id = "cnf_passErr"></span>
								</div>									
	  						</div>
							<!-- Date Of Birth -->
							<div class="form-row padding-sm">
								<div class="col">								
									<input type="text" class="form-control bg-trans-white text-colour" placeholder="Date of birth *" name = "birthDate" id = "date_of_birth">
									<span class = "text-xs color-red" id = "dobErr"></span>
								</div>	
								<div class="col">
									<select class="custom-select bg-trans-white text-colour" id="inputUser">
										<option value='-2'>Choose User Type *</option>
										<option>CANDIDATE</option>
										<option>TEST GENERATOR</option>
										<option>QUESTION BANK CREATOR</option>
										<option>REGISTRAR</option>
									</select>
									<span class = "text-xs color-red" id = "userType"></span>
								</div>								
							</div>
							<div class="form-row padding-sm" id = "registrar_info">
							  <!-- Email-id -->
	    						<div class="col">
									<input type="text" class="form-control bg-trans-white text-colour" placeholder="Organization Name *" id = "collegeName">
									<span class = "text-xs color-red" id = "collegeNamelErr"></span>
								</div>
								<!-- Password -->
	   						 	<div class="col">
	     						    <input type="text" class="form-control bg-trans-white text-colour" placeholder="Designation *" id = "designation">
									<span class = "text-xs color-red" id = "designationErr"></span>
								</div>									
	  						</div>
							<!-- User Type -->
   						 	<div class="padding-sm row">
								<div class = "col-md-6">
									<div class="col-md-4 p-0 float-left d-inline">
										<label>Gender:</label>
									</div>

									<div class="col-md-8 float-left">
										<div class="form-check custom-control-inline custom-radio">
											<input class="form-check-input custom-control-input" type="radio" name="gender" id="male" value="male">
											<label class="form-check-label custom-control-label" for="male">
												Male
											</label>
											</div>
											<div class="form-check custom-control-inline custom-radio mb-3">
											<input class="form-check-input custom-control-input" type="radio" name="gender" id="female" value="female">
											<label class="form-check-label custom-control-label" for="female">
												Female
											</label>
										</div>									
									</div>
									<span class = "text-xs color-red" id = "genderErr"></span>
								</div>
								<!-- Gender -->	
								
								<div class = "col-md-6 pl-1 permissions">
									<button type = "button" class="btn btn-warning btn-sm btn-block" id ="permissions">Set Permission</button> 
									<span class = "text-xs pt-3 color-red" id = "permissionErr"> </span>
								</div>									 											
   						 	</div>
							<div class = "padding-sm row permissions" id = "show_permissions">
								<div class = "col"></div>
								
								<div class = "col float-right" >
									<!-- <input type = "checkbox" class = "bg-danger text-light " name = "ALL_CHECK" value = "all" id = "checkAll" width = "100%">Set All Permissions<br> -->
									<input type = "checkbox" name='check' class = "check gt" value= "GENERATE_TEST">Generate Tests<br>
									<input type = "checkbox" name='check' class = "check cqb" value ="CREATE_QUESTION_BANK">Create Queston Bank<br>										
									<input type = "checkbox" name='check' class = "check cu" value="CREATE_USER">Create Users<br>
									<input type = "checkbox" name='check' class = "check aqb" value= "ACCESS_QUESTION_BANK">Access Queston Bank<br>
									<input type = "checkbox" name='check' class = "check vr" value ="VIEW_RESULT">View Results<br>				
								</div>
								
							</div>
							
								

			<!-- Table to add Education Details  -->
		<div class="table-responsive">
			<table class="table table-bordered">
  				<h6 class="text-center font-weight-bold bg-info text-light py-2 my-4">Education Details</h6>
  				<tbody>
    				<tr>
      					<td>	
      						<select class= "form-control text-sm" id = "addEdu" >
		                        <option value = -2>Select Education</option>
		                        <option value = "B.E(IT)">B.E(IT)</option>
		                        <option value = "B.E(CS)">B.E(CS)</option>
		                        <option value = "B.E(ETC)">B.E(ETC)</option>
		                        <option value = "B.E(MEC)">B.E(MEC)</option>
		                        <option value = "B.E(CIVIL)">B.E(CIVIL)</option>
		                        <option value = "B.E(ARCH)">B.E(ARCH)</option>
		                        <option value = "B.Sc">B.Sc</option>
		                        <option value = "B.C.A">B.C.A</option>
		                        <option value = "Polytechnic">Polytechnic</option>

		                    </select>
							<!-- <input type="text" class="form-control bg-trans-white text-colour" placeholder = "Enter Education" id = "addEdu"> -->
							<span class = "text-xs color-red" id = "educationErr"></span>							
						</td>
      					<td>
							<input type="text" class="form-control bg-trans-white text-colour" placeholder = " Enter Board/University" id = "addUniversity">
							<span class = "text-xs color-red" id = "universityErr"></span>							
      					</td>
      					<td>
						  <input type="text" class="form-control bg-trans-white text-colour" placeholder = "Enter Passout Year" id="addPassingYear" maxlength=4 onkeyup = "check_pass_year()">
							<span class = "text-xs color-red" id = "passingYearErr"></span>
      					</td>
      					<td>
      						<input type="text" class="form-control bg-trans-white text-colour" placeholder="99.99 %" maxlength = 5 id="percentage" onkeyup="check_percentage()">
							<span class = "text-xs color-red" id = "percentageErr"></span>
      					</td>
      					<td scope="col">
      						<button type="button" class="btn btn-primary fa fa-plus" id = "addMoreEdu" onclick="addmoreEdu();"></button>
      					</td>
    				</tr>
  				</tbody>
			</table>

			<table class="table table-bordered">
				<thead>
				    <tr>
						<th scope="col">Education</th>
						<th scope="col">Board/University</th>
						<th scope="col">Year of Passing</th>
						<th scope="col">%</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody id = "eduTable">
						    
				</tbody>
			</table>


		</div>
		</form><hr>
		<div class="padding-xs bottom-margin">
			<button type="button" class="btn btn-sm btn-success float-right" onclick = "register();">Submit</button>
			<button type="button" class="btn btn-sm btn-primary mr-2 float-right" onclick = "reset_inputs();">Reset</button>
			<button type="button" class="btn btn-sm btn-dark float-right mr-2" onclick="window.location.href='admin_users.php'">Cancel</button>

		</div>
		</div>
	</div>

	<!-- alert model box -->
	<div class="modal fade bd-example-modal-sm" id="alert_box" tabindex="-1" role="dialog" aria-labelledby="action_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-body my-2" >
                <div class = "p-3" id = "alert_content"><h3>Success!</h3></div>
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
  	
	
	<script type="text/javascript" src="../js/registration.js"></script>
	<script type="text/javascript" src="../js/inputValidations.js"></script>
	<script type="text/javascript" src="../js/validations.js"></script>
	<script>
		selectValidation('#inputUser','#userType',"Please select user type");	
		selectValidation('#addEdu','#educationErr', "Please select Education");
		checkRequired('#addUniversity','#universityErr');
		checkRequired('#addPassingYear','#passingYearErr');			
		checkRequired('#percentage','#percentageErr');
		checkRequired('#first_name','#firstNameErr');
		checkRequired('#last_name','#lastNameErr');
		checkRequired('#password','#passwordErr');
		checkRequired('#cnf_password','#cnf_passErr');
		checkRequired('#collegeName','#collegeNameErr');
		checkRequired('#designation','#designationErr');
		checkRequired('#date_of_birth','#dobErr');
		checkRequired('#mobile_no','#mobileErr');
		checkEmail('#email_id','#emailErr');
		checkRadio('#genderErr');
	</script>
	</body>
</html>