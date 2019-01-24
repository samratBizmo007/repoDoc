<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<p class="text-danger text-center"><i class="icon fa fa-warning"></i> <?php echo h($message) ?></p>
