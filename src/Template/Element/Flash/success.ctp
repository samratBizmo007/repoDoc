<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    if(is_array($message)) {
        $message = implode("<br>", $message);
    } else {
        $message = h($message);
    }
}
?>
<div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div>
