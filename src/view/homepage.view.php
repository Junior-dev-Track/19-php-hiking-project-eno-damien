<?php
ob_start();
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-auto max-w-screen-xl py-8">
    <?php foreach ($hike_array as $hike) : ?>
        <div class="card bg-white shadow-xl rounded-lg overflow-hidden flex flex-col">
            <div class="overflow-hidden">
                <a href="<?php echo BASE_PATH; ?>/hikes/<?= htmlspecialchars($hike["id"]); ?>">
                    <img src="<?php echo BASE_PATH; ?>/public/images/<?php echo htmlspecialchars($hike["id"] ?? 'default'); ?>.jpg" alt="<?= htmlspecialchars($hike['name']); ?>" class="w-full h-64 object-cover shadow-xl transform transition duration-500 hover:scale-110 cursor-pointer">
                </a>
            </div>
            <div class="p-4 flex flex-col justify-between h-1/2">
                <a href="<?php echo BASE_PATH; ?>/hikes/<?= htmlspecialchars($hike["id"]); ?>">
                    <h3 class="font-bold text-xl pb-1"><?= htmlspecialchars($hike["name"]); ?></h3>
                </a>
                <p class="inline-flex bg-green-500 text-white px-2 py-0.5 rounded"><?= htmlspecialchars($hike["distance"]); ?>KM - <?= htmlspecialchars($hike["duration"] ?? 'N/A'); ?> Hours</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$contentBody = ob_get_clean();
$contentHeader = "";
$contentFooter = "";

require('layout.view.php');
