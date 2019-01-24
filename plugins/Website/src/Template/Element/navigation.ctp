<?php 
    $home = $privacy_class = $privacy = "";
    switch ($this->request->params['action']) {
        case 'index':
            $home = "active";
            break;
        case 'privacyPolicy':
            $privacy = "active";
            $privacy_class = "privacy";
            break;

        default:
            break;
    }

?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top <?php echo $privacy_class ?>" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
            <?php 
                echo $this->Html->image('Website.logo-92.png',[
                    'alt' => 'Logo'
                ]);
            ?>
            <h2>Daily Doc</h2>
        </a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
         aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" data-href="<?php echo $this->Url->build('/') ?>" href="#header">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" data-href="<?php echo $this->Url->build('/') ?>" href="#about-us">About US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" data-href="<?php echo $this->Url->build('/privacy-policy') ?>" href="#privacy-policy">Privacy Policy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" data-href="<?php echo $this->Url->build('/') ?>" href="#mission">Mission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" data-href="<?php echo $this->Url->build('/') ?>" href="#contact-us">Contact US</a>
                </li>
            </ul>
        </div>
    </div>
</nav>