<?php
$file = $theme['folder'] . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'user-panel.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<div class="user-panel">
    <div class="pull-left image">
        <?php 
            /* echo $this->Html->image($current_user['photo_url'], [
                'class' => 'img-circle', 
                'alt' => $current_user['firstname']." ".$current_user['lastname']]
            );  */
        ?>
        <div class="img-circle image-crop user-panel-image" style="background-image: url('<?php echo $current_user['photo_url']; ?>')"></div>
    </div>
    <div class="pull-left info" style="<?php if(!empty($current_user['hospitals']['name'])) {?>padding: 0px 5px 5px 15px;<?php }?>">
        <p><?php echo (!empty($current_user)) ? $current_user['firstname']." ".$current_user['lastname'] : "Admin"; ?></p>
        <?php if(!empty($current_user['hospitals']['name'])) {?>
        	<p><?php echo $current_user['hospitals']['name']; ?></p>
        <?php }?>
    </div>
</div>
<?php } ?>