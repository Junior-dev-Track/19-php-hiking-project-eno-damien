<?php
//Display the session info after the registration
$user_identifiant = isset($_SESSION['user']['sess_user']) ? $_SESSION['user']['sess_user'] : null;
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
ob_start(); ?>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

<nav class="bg-green-500 p-6">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-10">
            <a href="/">
                <img class="h-10 w-10 rounded-full" src="<?php echo BASE_PATH; ?>/public/images/logo.jpg" alt="Your Logo">
            </a>
            <?php if ($user_identifiant) { ?>
                <div style="color: #F9FAFB; position: relative; left: 50px;">
                    <?php echo " WELCOME " . strtoupper($user_identifiant); ?>
                </div>
            <?php } ?>
        </div>
        <div class="space-x-4">
            <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/">HOME</a>
            <?php if (empty($user_identifiant)) { ?>
                <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/login">LOGIN</a>
                <a class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" href="<?php echo BASE_PATH; ?>/register">REGISTER</a>
            <?php } else { ?>
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" type="button" class="text-white text-lg hover:text-green-300 transition duration-200 ease-in-out nav-link" id="options-menu" aria-haspopup="true" aria-expanded="true">
                            SETTINGS
                        </button>
                    </div>
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="z-index: 1000;">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <a href="<?php echo BASE_PATH; ?>/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Edit</a>
                            <a href="<?php echo BASE_PATH; ?>/addhike" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Add Hike</a>
                            <a href="<?php echo BASE_PATH; ?>/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</a>
                        </div>
                    </div>
                </div>
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