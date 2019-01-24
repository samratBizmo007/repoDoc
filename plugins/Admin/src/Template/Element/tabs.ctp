<?php 
  $departments = $designations = $employee_roles = $sub_departments = $titles = $service_teams = $events  = $floors = $hospital_beds ="";
  $controller = $this->request->params['controller'];
  
  if($controller == 'EmployeeRoles')
    $employee_roles  = 'active';

  else if($controller == 'Departments')
    $departments  = 'active';

  else if($controller == 'SubDepartments')
    $sub_departments  = 'active';

  else if($controller == 'Designations')
    $designations  = 'active';

  else if($controller == 'Titles')
    $titles  = 'active';

  else if($controller == 'ServiceTeams')
    $service_teams  = 'active';

  else if($controller == 'Floors')
    $floors  = 'active';
  
  else if($controller == 'HospitalBeds')
    $hospital_beds  = 'active';

  /* else if($controller == 'Events')
    $events  = 'active'; */
?>
<ul class="nav nav-tabs tabs-primary">
  <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2): ?>
      <li class="<?php echo $employee_roles ?>">
          <a href="<?php echo $this->Url->build(['controller' => 'EmployeeRoles','action' => 'index']); ?>" aria-expanded="false">
              Employee Roles
          </a>
      </li>
      <li class="<?php echo $departments ?>">
        <a href="<?php echo $this->Url->build(['controller' => 'Departments','action' => 'index']); ?>" aria-expanded="false">
          Departments
        </a>
      </li>
      <li class="<?php echo $sub_departments ?>">
        <a href="<?php echo $this->Url->build(['controller' => 'SubDepartments','action' => 'index']); ?>" aria-expanded="false">
          Sub Departments
        </a>
      </li>
  <?php endif; ?>
  <li class="<?php echo $designations ?>">
    <a href="<?php echo $this->Url->build(['controller' => 'Designations','action' => 'index']); ?>" aria-expanded="false">  Designations
    </a>
  </li>
  <li class="<?php echo $titles ?>">
    <a href="<?php echo $this->Url->build(['controller' => 'Titles','action' => 'index']); ?>" aria-expanded="false">
      Titles
    </a>
  </li>
  <li class="<?php echo $service_teams ?>">
    <a href="<?php echo $this->Url->build(['controller' => 'ServiceTeams','action' => 'index']); ?>" aria-expanded="false">  Service Teams
    </a>
  </li>
  <li class="<?php echo $floors ?>">
    <a href="<?php echo $this->Url->build(['controller' => 'Floors','action' => 'index']); ?>" aria-expanded="false">
      Floors
    </a>
  </li>

  <li class="<?php echo $hospital_beds ?>">
    <a href="<?php echo $this->Url->build(['controller' => 'HospitalBeds','action' => 'index']); ?>" aria-expanded="false">
      Hospital Beds
    </a>
  </li>

</ul>