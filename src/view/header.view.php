<?php
ob_start(); ?>

<div class="bg-blue-500 text-white p-4">
    <p>Ceci est un exemple de texte avec Tailwind CSS.</p>
</div>

<?php
$contentHeader = ob_get_clean();
$contentBody = "";
$contentFooter = "";
require(__DIR__ . '/layout.view.php');
?>