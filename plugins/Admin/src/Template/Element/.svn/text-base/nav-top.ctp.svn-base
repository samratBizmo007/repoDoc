<?php
$file = $theme['folder'] . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'nav-top.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="javascript:void(0)" class="dropdown-toggle">
                    <span class="hidden-xs">
                        <b> Welcome ! </b> <?php echo (!empty($current_user)) ? $current_user['firstname']." ".$current_user['lastname'] : "Admin"; ?>
                    </span>
                </a>
            </li>

            <!-- Control Sidebar Toggle Button -->
            <li>
                <a href="<?php echo $this->Url->build('/users/logout'); ?>">
                    <i class="fa fa-power-off"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>