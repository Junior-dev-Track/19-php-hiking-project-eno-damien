<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
    <?= $contentHeader ?>
    <?= $contentBody ?>
    <?= $contentFooter ?>
</body>
<script src="<?php echo BASE_PATH ?>/src/js/script.js"></script>

</html>