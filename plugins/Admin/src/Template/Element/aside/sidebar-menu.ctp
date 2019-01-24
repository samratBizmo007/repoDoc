<?php

$controller = $this->request->controller;
$action = $this->request->action;

$file = $theme['folder'] . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>


<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2 || $current_user['role_id'] == 3): ?>
    <li class="treeview <?= ($controller == 'Dashboard') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-dashboard"></i> <span>Dashboard</span>'),
                ['controller' => 'Dashboard', 'action' => 'index'],
                ['escape' => false]
            );
        ?>
    </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2 || $current_user['role_id'] == 3): ?>
    <li class="treeview <?= ($controller == 'Users') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-user"></i> <span>Manage Admins</span>'),
                ['controller' => 'Users', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
	<?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2): ?>
    <li class="treeview <?= ($controller == 'Hospitals') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-medkit"></i> <span>Manage Hospitals</span>'),
                ['controller' => 'Hospitals', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <li class="treeview <?= ($controller == 'Roles') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-user-circle-o"></i> <span>Admin Roles</span>'),
                ['controller' => 'Roles', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2  || $current_user['role_id'] == 3 || $current_user['role_id'] == 5): ?>
    <li class="treeview <?= ($controller == 'Employees') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-user-circle-o"></i> <span>Manage Employees</span>'),
                ['controller' => 'Employees', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2  || $current_user['role_id'] == 3  || $current_user['role_id'] == 4): ?>
    <li class="treeview <?= ($controller == 'Patients') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-user-circle-o"></i> <span>Manage Patients</span>'),
                ['controller' => 'Patients', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2 || $current_user['role_id'] == 3 || $current_user['role_id'] == 5): ?>
     <li class="treeview <?= ($controller == 'EmployeesSchedules') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-calendar"></i> <span>Schedules</span>'),
                ['controller' => 'EmployeesSchedules', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2): ?>
    <li class="treeview <?= ($controller == 'EmployeeRoles' || $controller == 'Departments' || $controller == 'SubDepartments' || $controller == 'Designations' || $controller == 'Titles' || $controller == 'ServiceTeams' || $controller == 'Events') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-cogs"></i> <span>Manage Roles</span>'),
                ['controller' => 'EmployeeRoles', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php elseif ($current_user['role_id'] == 3): ?>
    	<li class="treeview <?= ($controller == 'Designations' || $controller == 'Titles' || $controller == 'ServiceTeams' || $controller == 'Events') ? 'active' : '' ?>">
            <?php 
                echo $this->Html->link(__('<i class="fa fa-cogs"></i> <span>Settings</span>'),
                    ['controller' => 'Designations', 'action' => 'index'],
                    ['escape' => false]
                ); 
            ?>
        </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2 || $current_user['role_id'] == 3): ?>
    <li class="treeview <?= $controller == 'PatientHistories' ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-history"></i> <span>History</span>'),
                ['controller' => 'PatientHistories', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
    <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2  || $current_user['role_id'] == 3): ?>
    <li class="treeview <?= ($controller == 'Pages') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-newspaper-o"></i> <span>Pages</span>'),
                ['controller' => 'Pages', 'action' => 'index'],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
	<?php if($current_user['role_id'] == 4 || $current_user['role_id'] == 5): ?>
    <li class="treeview <?= ($controller == 'Users') ? 'active' : '' ?>">
        <?php 
            echo $this->Html->link(__('<i class="fa fa-user"></i> <span>Profile</span>'),
                ['controller' => 'Users', 'action' => 'edit', $current_user['id']],
                ['escape' => false]
            ); 
        ?>
    </li>
    <?php endif; ?>
</ul>
<?php } ?>


