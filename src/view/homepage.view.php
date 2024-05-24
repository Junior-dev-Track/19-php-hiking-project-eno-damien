<?php
ob_start();

foreach ($hike_array as $hike) : ?>
    <li>
        <a href="/20-CLASSIC-MVC-ROUTEUR/productdetails/<?= htmlspecialchars($Product['productCode']); ?>">
            <h3>Name : <?= htmlspecialchars($hike["name"]); ?></h3>
            <p>duration :<?= htmlspecialchars($hike["duration"]); ?></p>
        </a>
    <?php
endforeach;
    ?>
    </ol>


    <?php $contentBody = ob_get_clean();
    $contentHeader = "";
    $contentFooter = "";
    ?>

    <?php require('layout.view.php') ?>