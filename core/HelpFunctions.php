<?php

define('RECAPTCHA_SITE_KEY', '6Ld9HrAmAAAAADmTDQGUaahvRTSIlLzxTSDqQ6Km');
define('RECAPTCHA_SECRET_KEY', '6Ld9HrAmAAAAAPbF1rB2gNz1UlLhS1zGlHak4m--');
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    
    return $data;
}
?>