<?php 
ob_start(); ?>
<header> 
 <p>Footer</p>
</header> 

<?php 
$contentHeader = "";
$contentBody = "";
$contentFooter = ob_get_clean();
require(__DIR__ . '/layout.view.php');
?>