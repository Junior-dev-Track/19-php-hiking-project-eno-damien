<?php
ob_start();
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-auto max-w-screen-xl py-8">
    <?php foreach ($hike_array as $hike) : ?>
        <div class="card bg-white shadow-xl rounded-lg overflow-hidden">
            <img src="public/images/<?= htmlspecialchars($hike['id'] ?? 'default'); ?>.jpg" alt="<?= htmlspecialchars($hike['name']); ?>" class="w-full h-64 object-cover shadow-xl">
            <div class="p-4">
                <h3 class="font-bold text-xl pb-8 py-1"><?= htmlspecialchars($hike["name"]); ?></h3>
                <p class="inline-block bg-blue-500 text-white px-2 py-0.5 rounded"><?= htmlspecialchars($hike["distance"]); ?>KM</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$contentBody = ob_get_clean();
$contentHeader = "";
$contentFooter = "";

require('layout.view.php');
