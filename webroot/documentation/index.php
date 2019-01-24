<?php
	$DOC_URL = '';

	$servername = $_SERVER['SERVER_NAME'];

	if($servername == "localhost")
		$DOC_URL = 'LOCAL SERVER URL : '.'http://localhost/daily_doc/apis/';
	if($servername == "192.168.2.90")
		$DOC_URL = 'LOCAL SERVER URL : '.'http://192.168.2.90/daily_doc/apis/';
	else if($servername == "54.251.97.231")
		$DOC_URL = 'TEST SERVER URL : '.'http://54.251.97.231/daily_doc/apis/';
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from getbootstrap.com/javascript/ by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 02 Oct 2013 12:11:59 GMT -->
<head>
	<?php include('inc/head.php'); ?>
</head>
<body>
	<a class="sr-only" href="#content">Skip navigation</a>
	<!-- Docs master nav -->
	<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
		<?php include('inc/header.php'); ?>
	</header>
	<!-- Docs page layout -->
	<div class="bs-header" id="content">
		<div class="container">
			<h1>Daily Doc</h1>
		</div>
	</div>
	<div class="container bs-docs-container">
		<div id="back-to-top">
            <a class="back-top">
                <img src="assets/img/top_button.png"/>
            </a>
        </div>
		<div class="row">
			<div class="col-md-3">
				<div class="bs-sidebar hidden-print" role="complementary">
					<ul class="nav bs-sidenav" style="max-height: 500px;  overflow-y: scroll;">
						<li>
							<a href="#login">Login</a>
							<ul class="nav">
								<li><a href="#type1">Type</a></li>
								<li><a href="#input1">Input</a></li>
								<li><a href="#output1">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#forgot_password">Forgot Password</a>
							<ul class="nav">
								<li><a href="#type27">Type</a></li>
								<li><a href="#input27">Input</a></li>
								<li><a href="#output27">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#change_password">Change Password</a>
							<ul class="nav">
								<li><a href="#type28">Type</a></li>
								<li><a href="#input28">Input</a></li>
								<li><a href="#output28">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#pataients_lists">Pataients Lists</a>
							<ul class="nav">
								<li><a href="#type3">Type</a></li>
								<li><a href="#input3">Input</a></li>
								<li><a href="#output3">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#department_lists">Department Lists</a>
							<ul class="nav">
								<li><a href="#type4">Type</a></li>
								<li><a href="#input4">Input</a></li>
								<li><a href="#output4">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#employee_role_lists">Employee Role Lists</a>
							<ul class="nav">
								<li><a href="#type29">Type</a></li>
								<li><a href="#input29">Input</a></li>
								<li><a href="#output29">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#search_provider_lists">Search Provider Lists</a>
							<ul class="nav">
								<li><a href="#type5">Type</a></li>
								<li><a href="#input5">Input</a></li>
								<li><a href="#output5">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#search_employee">Search Employee</a>
							<ul class="nav">
								<li><a href="#type30">Type</a></li>
								<li><a href="#input30">Input</a></li>
								<li><a href="#output30">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#search_pataients">Search Pataients</a>
							<ul class="nav">
								<li><a href="#type6">Type</a></li>
								<li><a href="#input6">Input</a></li>
								<li><a href="#output6">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#add_employee_pataients">Add Employee Pataients</a>
							<ul class="nav">
								<li><a href="#type7">Type</a></li>
								<li><a href="#input7">Input</a></li>
								<li><a href="#output7">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#add_pataients_on_dashboard">Add Patients On Dashboard</a>
							<ul class="nav">
								<li><a href="#type31">Type</a></li>
								<li><a href="#input31">Input</a></li>
								<li><a href="#output31">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#remove_employee_patients">Remove Employee Patients</a>
							<ul class="nav">
								<li><a href="#type32">Type</a></li>
								<li><a href="#input32">Input</a></li>
								<li><a href="#output32">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#patient_service_team">Patient Service Team</a>
							<ul class="nav">
								<li><a href="#type8">Type</a></li>
								<li><a href="#input8">Input</a></li>
								<li><a href="#output8">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#patient_view_notes">Patient View Notes</a>
							<ul class="nav">
								<li><a href="#type9">Type</a></li>
								<li><a href="#input9">Input</a></li>
								<li><a href="#output9">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#patient_signout_notes">Patient Signout Notes</a>
							<ul class="nav">
								<li><a href="#type10">Type</a></li>
								<li><a href="#input10">Input</a></li>
								<li><a href="#output10">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#patient_followups">Patient Followups</a>
							<ul class="nav">
								<li><a href="#type11">Type</a></li>
								<li><a href="#input11">Input</a></li>
								<li><a href="#output11">Output</a></li>
							</ul>
						</li>
						<!-- <li>
							<a href="#event_lists">Event Lists</a>
							<ul class="nav">
								<li><a href="#type12">Type</a></li>
								<li><a href="#input12">Input</a></li>
								<li><a href="#output12">Output</a></li>
							</ul>
						</li> -->
						<li>
							<a href="#patient_major_events">Patient Major Events</a>
							<ul class="nav">
								<li><a href="#type13">Type</a></li>
								<li><a href="#input13">Input</a></li>
								<li><a href="#output13">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#create_followups">Create Followups</a>
							<ul class="nav">
								<li><a href="#type14">Type</a></li>
								<li><a href="#input14">Input</a></li>
								<li><a href="#output14">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#create_signout_note">Create Signout Note</a>
							<ul class="nav">
								<li><a href="#type15">Type</a></li>
								<li><a href="#input15">Input</a></li>
								<li><a href="#output15">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#create_major_event">Create Major Event</a>
							<ul class="nav">
								<li><a href="#type16">Type</a></li>
								<li><a href="#input16">Input</a></li>
								<li><a href="#output16">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#create_reminder">Create Reminder</a>
							<ul class="nav">
								<li><a href="#type17">Type</a></li>
								<li><a href="#input17">Input</a></li>
								<li><a href="#output17">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#patient_reminders">Patient Reminders</a>
							<ul class="nav">
								<li><a href="#type18">Type</a></li>
								<li><a href="#input18">Input</a></li>
								<li><a href="#output18">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#edit_patient_detail">Edit Patient Detail</a>
							<ul class="nav">
								<li><a href="#type33">Type</a></li>
								<li><a href="#input33">Input</a></li>
								<li><a href="#output33">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#edit_employee_profile">Edit Employee Profile</a>
							<ul class="nav">
								<li><a href="#type34">Type</a></li>
								<li><a href="#input34">Input</a></li>
								<li><a href="#output34">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#my_patient_signout_notes">My Patient Signout Notes</a>
							<ul class="nav">
								<li><a href="#type19">Type</a></li>
								<li><a href="#input19">Input</a></li>
								<li><a href="#output19">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#my_patient_followups">My Patient Followups</a>
							<ul class="nav">
								<li><a href="#type20">Type</a></li>
								<li><a href="#input20">Input</a></li>
								<li><a href="#output20">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#all_patient_followups">All Patient Followups</a>
							<ul class="nav">
								<li><a href="#type35">Type</a></li>
								<li><a href="#input35">Input</a></li>
								<li><a href="#output35">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#my_patient_notes">My Patient Notes</a>
							<ul class="nav">
								<li><a href="#type36">Type</a></li>
								<li><a href="#input36">Input</a></li>
								<li><a href="#output36">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#static_pages">Static Pages</a>
							<ul class="nav">
								<li><a href="#type21">Type</a></li>
								<li><a href="#input21">Input</a></li>
								<li><a href="#output21">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#employee_detail">Employee Detail</a>
							<ul class="nav">
								<li><a href="#type22">Type</a></li>
								<li><a href="#input22">Input</a></li>
								<li><a href="#output22">Output</a></li>
							</ul>
						</li>
						<!-- <li>
							<a href="#patient_handoff">Patient Handoff</a>
							<ul class="nav">
								<li><a href="#type23">Type</a></li>
								<li><a href="#input23">Input</a></li>
								<li><a href="#output23">Output</a></li>
							</ul>
						</li> -->
						
						<li>
							<a href="#create_employee_plans">Create Employee Plans</a>
							<ul class="nav">
								<li><a href="#type24">Type</a></li>
								<li><a href="#input24">Input</a></li>
								<li><a href="#output24">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#firstcall_attending_lists">Firstcall And Attending Lists</a>
							<ul class="nav">
								<li><a href="#type25">Type</a></li>
								<li><a href="#input25">Input</a></li>
								<li><a href="#output25">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#create_notes">Create Notes</a>
							<ul class="nav">
								<li><a href="#type26">Type</a></li>
								<li><a href="#input26">Input</a></li>
								<li><a href="#output26">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#edit_notes">Edit Notes</a>
							<ul class="nav">
								<li><a href="#type37">Type</a></li>
								<li><a href="#input37">Input</a></li>
								<li><a href="#output37">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#edit_followups">Edit FollowUps</a>
							<ul class="nav">
								<li><a href="#type38">Type</a></li>
								<li><a href="#input38">Input</a></li>
								<li><a href="#output38">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#employee_schedule">Employee Schedule</a>
							<ul class="nav">
								<li><a href="#type39">Type</a></li>
								<li><a href="#input39">Input</a></li>
								<li><a href="#output39">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#provider_detail">Provider Detail</a>
							<ul class="nav">
								<li><a href="#type40">Type</a></li>
								<li><a href="#input40">Input</a></li>
								<li><a href="#output40">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#delete_reminder">Delete Reminder</a>
							<ul class="nav">
								<li><a href="#type41">Type</a></li>
								<li><a href="#input41">Input</a></li>
								<li><a href="#output41">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#delete_signout_notes">Delete Signout Notes</a>
							<ul class="nav">
								<li><a href="#type42">Type</a></li>
								<li><a href="#input42">Input</a></li>
								<li><a href="#output42">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#delete_major_event">Delete Major Event</a>
							<ul class="nav">
								<li><a href="#type43">Type</a></li>
								<li><a href="#input43">Input</a></li>
								<li><a href="#output43">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#delete_followups">Delete Followups</a>
							<ul class="nav">
								<li><a href="#type44">Type</a></li>
								<li><a href="#input44">Input</a></li>
								<li><a href="#output44">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#user_notification">Set User Notification</a>
							<ul class="nav">
								<li><a href="#type45">Type</a></li>
								<li><a href="#input45">Input</a></li>
								<li><a href="#output45">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#change_reminder_status">Change Reminder Status</a>
							<ul class="nav">
								<li><a href="#type46">Type</a></li>
								<li><a href="#input46">Input</a></li>
								<li><a href="#output46">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#change_followup_status">Change Followup Status</a>
							<ul class="nav">
								<li><a href="#type47">Type</a></li>
								<li><a href="#input47">Input</a></li>
								<li><a href="#output47">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#department_subdepartment_lists">Department Subdepartment Lists</a>
							<ul class="nav">
								<li><a href="#type48">Type</a></li>
								<li><a href="#input48">Input</a></li>
								<li><a href="#output48">Output</a></li>
							</ul>
						</li>
						<li>
							<a href="#logout">Logout</a>
							<ul class="nav">
								<li><a href="#type2">Type</a></li>
								<li><a href="#input2">Input</a></li>
								<li><a href="#output2">Output</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-9" role="main">
				<div class="bs-docs-section">
					<div class="page-header">
						<section>
							<?php include('apis/login.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/forgot_password.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/reset_password.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/pataients_lists.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/department_lists.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/employee_role_lists.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/search_provider_lists.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/search_employee.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/search_pataients.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/add_employee_pataients.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/add_pataients_on_dashboard.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/remove_employee_pataients.php'); ?>
				 		</section>
				 		<section>
							<?php include('apis/patient_service_team.php'); ?>
				 		</section>
				 		<section>
                        	<?php include('apis/patient_view_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/patient_signout_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/patient_followups.php'); ?>
                        </section>
                        <!-- <section>
                        	<?php //include('apis/event_lists.php'); ?>
                        </section>-->
                        <section>
                        	<?php include('apis/patient_major_events.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/create_followups.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/create_signout_note.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/create_major_event.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/create_reminder.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/patient_reminders.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/edit_patient_detail.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/edit_employee_profile.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/my_patient_signout_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/my_patient_followups.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/all_patient_followups.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/my_patient_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/static_pages.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/employee_detail.php'); ?>
                        </section>
                        <!-- <section>
                        	<?php //include('apis/patient_handoff.php'); ?>
                        </section> -->
                        <section>
                        	<?php include('apis/create_employee_plans.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/firstcall_attending_lists.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/create_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/edit_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/edit_followups.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/employee_schedule.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/provider_detail.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/delete_reminder.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/delete_signout_notes.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/delete_major_event.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/delete_followups.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/user_notification.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/change_reminder_status.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/change_followup_status.php'); ?>
                        </section>
                        <section>
                        	<?php include('apis/department_subdepartment_lists.php'); ?>
                        </section>
                        <section>
							<?php include('apis/logout.php'); ?>
				 		</section>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- JS and analytics only. -->
	
	<!-- Bootstrap core JavaScript -->
	
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/js/jquery.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	<script src="assets/js/application.js"></script>
	<script>
		$(function() {
	        $(window).scroll(function() {
	            if ($(this).scrollTop() > 100) {
	                $('#back-to-top').fadeIn();
	            } else {
	                $('#back-to-top').fadeOut();
	            }
	        });

	        // scroll body to 0px on click
	        $('#back-to-top a').click(function() {
	            $('body,html').animate({
	                scrollTop: 0
	            }, 800);
	            return false;
	        });
	    });
	</script>
	<!-- Analytics -->
</body>

</html>
