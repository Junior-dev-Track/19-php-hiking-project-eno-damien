<?php
ob_start();
?>

<div class="grid grid-cols-4 gap-4">
    <?php foreach ($hike_array as $hike) : ?>
        <div class="card">
            <img src="public/images/<?= htmlspecialchars($hike['id'] ?? 'default'); ?>.jpg" alt="<?= htmlspecialchars($hike['name']); ?>" class="w-full h-64 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-xl"><?= htmlspecialchars($hike["name"]); ?></h3>
                <p>Distance: <?= htmlspecialchars($hike["distance"]); ?> KM</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$contentBody = ob_get_clean();
$contentHeader = "";
$contentFooter = "";

require('layout.view.php');
