<?php
session_start();
//error_reporting(0);
include 'include/config.php';
include 'include/checklogin.php';
check_login();

if (isset($_POST['submit'])) {

	$type = $_POST['symptomType'];
	$symptom = $_POST['symptom_list'];
	$userid = $_SESSION['id'];
	$duration = $_POST['duration'];
	$tested = $_POST['tested'];
	$touched = $_POST['touched'];
	$appdate = $_POST['appdate'];
	$chk = "";
	$notify = "must see doctor";
	$level = 2;

	// ----------------------notification builder start
	

	//-----------------------notification builder end

	foreach ($symptom as $chk1) {
    $chk .= $chk1 . ",";
	}

    $query = mysqli_query($con, "insert into symptoms(user_id, symptom_type, symptoms, duration, covid_test, covid_touch, date, userStatus) values('$userid','$type','$chk','$duration','$tested', '$touched','$appdate', 1)");
    if ($query) {
        echo "<script>alert('Your daily update added successfully');</script>";
    }
	else  
   {  
      echo'<script>alert("Failed To Insert")</script>';  
   }

   if($duration>=5){
		$queryNotify = mysqli_query($con, "insert into notification(user_id, symptom_type, symptoms, date, notification, level) values('$userid','$type','$chk','$appdate', '$notify', '$level')");
   }
   


}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User  | Daily Update</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>

	<body>
		<div id="app">
            <?php include 'include/sidebar.php';?>
			<div class="app-content">

						<?php include 'include/header.php';?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">User | Update Symptoms</h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>User</span>
									</li>
									<li class="active">
										<span>Daily Update</span>
									</li>
								</ol>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">

									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Add Symptoms</h5>
												</div>
												<div class="panel-body">
													<p style="color:red;"><?php echo htmlentities($_SESSION['msg1']); ?>
													<?php echo htmlentities($_SESSION['msg1'] = ""); ?></p>
													<form role="form" name="book" method="post" >
														

														<div class="form-group">
															<label for="DoctorSpecialization">
																Symptom Type
															</label>
															<select name="symptomType" class="form-control" required="required">
																<option value="">Select Symptom Type</option>
																<?php $ret = mysqli_query($con, "select * from symptomtype");
																	while ($row = mysqli_fetch_array($ret)) {
    															?>
																<option value="<?php echo htmlentities($row['type_name']); ?>">
																<?php echo htmlentities($row['type_name']); ?>
																</option>
																<?php }?>

															</select>
														</div>
														
														<div class="form-group">
															<label for="symptoms"> Select Symptoms</label> <br>
															 	<input type="checkbox" id="symptom1" name="symptom_list[]" value="cold">
  																	<label for="symptom1"> Cold</label><br>
																<input type="checkbox" id="symptom2" name="symptom_list[]" value="fever">
																	<label for="symptom2"> Fever</label><br>
																<input type="checkbox" id="symptom3" name="symptom_list[]" value="cough">
																	<label for="symptom3"> Cough</label>   
<!--
																<fieldset>      
																	<legend>What are the symptoms you are having?</legend>      
																	<input type="checkbox" name="symptom" value="cold"> Cold   <input type="checkbox" name="symptom" value="cold"> Cold<br>      
																	<input type="checkbox" name="symptom" value="fever"> fever<br>      
																	<input type="checkbox" name="symptom" value="cough"> cough<br>      
																	<br>           
																</fieldset>   -->
														</div>

														<div class="form-group">
															<label for="days">
																For how many days do you have these symptoms?
															</label>
															<input type="number" class="form-control" name="duration"  required="required" >

														</div>

														<div class="form-group">
															<label for="days">
																Have you tested for Covid19 yet?
															</label> <br>
															<input type="radio" id="test" name="tested" value="Yes"> Yes &nbsp &nbsp &nbsp
															<input type="radio" id="test" name="tested" value="No" > No

														</div>

														<div class="form-group">
															<label for="days">
																To your knowledge, did you go near any covid19 affected people in last 14 days? 
															</label> <br>
															<input type="radio" id="test" name="touched" value="Yes"> Yes &nbsp &nbsp &nbsp
															<input type="radio" id="test" name="touched" value="No"> No &nbsp &nbsp &nbsp
															<input type="radio" id="test" name="touched" value="NotSure" > Not sure, went to a crowded place

														</div>


														<div class="form-group">
															<label for="AppointmentDate">
																Date
															</label>
															<input class="form-control datepicker" name="appdate"  required="required" data-date-format="yyyy-mm-dd">

														</div>

														<button type="submit" name="submit" class="btn btn-o btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>

									</div>
								</div>

							</div>
						</div>

						<!-- end: BASIC EXAMPLE -->






						<!-- end: SELECT BOXES -->

					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include 'include/footer.php';?>
			<!-- end: FOOTER -->

		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});

			$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d'
});
		</script>
		  <script type="text/javascript">
            $('#timepicker1').timepicker();
        </script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

	</body>
</html>
