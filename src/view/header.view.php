<?php
//Display the session info after the registration
$user_identifiant = isset($_SESSION['user']['sess_user']) ? $_SESSION['user']['sess_user'] : null;
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
ob_start(); ?>

<nav class="bg-green-500 p-6">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-10">
            <a href="/">
                <img class="h-10 w-10 rounded-full" src="<?php echo BASE_PATH; ?>/public/images/logo.jpg" alt="Your Logo">
            </a>
            <?php if ($user_identifiant) { ?>
                <div style="color: #F9FAFB; position: relative; left: 50px;">
                    <?php echo "WELCOME " . strtoupper($user_identifiant); ?>
                </div>
            <?php } ?>
        </div>
        <div class="space-x-4">
            <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/">Home</a>
            <?php if (empty($user_identifiant)) { ?>
                <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/login">Login</a>
                <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/register">Register</a>
            <?php } else { ?>
                <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/settings">Settings</a>
                <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/logout">Logout</a>
            <?php } ?>
        </div>
    </div>
</nav>

<?php
$contentHeader = ob_get_clean();
$contentBody = "";
$contentFooter = "";
require(__DIR__ . '/layout.view.php');
?>