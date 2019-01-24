<?php 
  $employee = $consult = "";
  
  $controller = $this->request->params['controller'];
  $method = $this->request->params['action'];
  
  if($controller == 'EmployeesSchedules' && $method == 'index')
    $employee  = 'active';

  else if($controller == 'EmployeesSchedules'  && $method == 'consult')
    $consult  = 'active';

?>

<ul class="nav nav-tabs tabs-primary">
  <li class="<?php echo $employee ?>">
      <a href="<?php echo $this->Url->build(['controller' => 'EmployeesSchedules','action' => 'index']); ?>" aria-expanded="false">
          Employee
      </a>
  </li>
  <li class="<?php echo $consult ?>">
    <a href="<?php echo $this->Url->build(['controller' => 'EmployeesSchedules','action' => 'consult']); ?>" aria-expanded="false">
      Consult
    </a>
  </li>
</ul>