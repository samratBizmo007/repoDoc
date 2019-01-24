<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

    
$this->layout = 'error';
?>

<section id="error">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <div class="errorc-code">
                        <div class="error-image-404"></div>
                    </div>
                    <div class="error-title">OOPS !</div>
                    <div class="error-message">Sorry, we couldn’t find the page you are looking for</div>
                    <div class="back-link text-center">
                        <?php echo $this->Html->link(__('Go Back To Home'), [
                            'controller' => '',
                            'action' => '/'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>