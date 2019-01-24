<?php 
    $notification_type = "";
    $flash_message = "";
    
    if(!empty($_SESSION['Flash']['positive']) && $_SESSION['Flash']['positive'][0]['key'] == 'positive'){
        $notification_type = "Success";
        $flash_message = $this->Flash->render('positive');
    } else {
        $notification_type = "Error";
        $flash_message = $this->Flash->render('negative');
    }
    
    if(!empty($flash_message)){ ?>
    <script type="text/javascript">
        var flash_message = "<?php echo trim(substr(strip_tags($flash_message), 0, strpos(strip_tags($flash_message),'.')))  ?>";
        var type = "<?php echo $notification_type ?>";
        if(type == "Success")
            toastr.success(flash_message, type , {timeOut: 5000})
        else if(type == "Error")
            toastr.error(flash_message, type , {timeOut: 5000})
    </script>       
<?php } ?>