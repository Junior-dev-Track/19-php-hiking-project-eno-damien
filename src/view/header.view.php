<?php
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: white;
            transition: width .3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
    <title>Hikes</title>
</head>

<body>
    <nav class="bg-green-500 p-6">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-10">
                <a href="/">
                    <img class="h-20 w-20 rounded-full" src="/public/images/logo.jpg" alt="Your Logo">
                </a>
            </div>
            <div class="space-x-4">
                <a class="text-white text-xl hover:text-gray-700 transition duration-200 ease-in-out nav-link" href="/">Home</a>
                <a class="text-white text-xl hover:text-gray-700 transition duration-200 ease-in-out nav-link" href="/login">Login</a>
                <a class="text-white text-xl hover:text-gray-700 transition duration-200 ease-in-out nav-link" href="/register">Register</a>
            </div>
        </div>
    </nav>
</body>

</html>

<?php
$contentHeader = ob_get_clean();
$contentBody = "";
$contentFooter = "";
require(__DIR__ . '/layout.view.php');
?>