
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
        <?php echo __('Dashboard')?>
      </h1>
	<ol class="breadcrumb">
		<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
		<li class="active"><?php echo __('Dashboard') ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Info boxes -->
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="ion ion-person-add"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('Users') ?></span>
					<span class="info-box-number"><?php echo h($totalUsers); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-olive"><i class="ion ion-person-stalker"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('Employees') ?></span>
					<span class="info-box-number"><?php echo h($totalEmployees); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-teal"><i class="ion ion-person-stalker"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('Patients') ?></span>
					<span class="info-box-number"><?php echo h($totalPatients); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-light-blue"><i class="ion ion-ios-world"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('ServiceTeams') ?></span>
					<span class="info-box-number"><?php echo h($totalServiceTeams); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-blue"><i class="ion ion-ios-list"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('Departments') ?></span>
					<span class="info-box-number"><?php echo h($totalDepartments); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="ion ion-ios-paper"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('Sub Departments') ?></span>
					<span class="info-box-number"><?php echo h($totalSubDepartments); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<?php if($current_user['role_id'] < 3) {?>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<!-- small box -->
			<div class="info-box">
				<span class="info-box-icon bg-maroon"><i class="ion ion-ios-medkit"></i></span>

				<div class="info-box-content">
					<span class="info-box-text"><?php echo __('Hospitals') ?></span>
					<span class="info-box-number"><?php echo h($totalHospitals); ?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<?php }?>
	</div>
	<!-- /.row -->
</section>
<!-- /.content -->