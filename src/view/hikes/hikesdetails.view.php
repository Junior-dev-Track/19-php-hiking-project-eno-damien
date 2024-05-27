<?php 
ob_start(); ?>

   
    <?php foreach ($hike_array as $hike) : ?>
        <div class="card">
            <img src="<?php echo BASE_PATH; ?>/public/images/<?php echo htmlspecialchars($hike["id"] ?? 'default'); ?>.jpg" alt="<?= htmlspecialchars($hike['name']); ?>" class="w-full h-64 object-cover">
            <div class="p-4">
                <p>Distance: <?= htmlspecialchars($hike["distance"]); ?> KM</p>
                <p>Duration: <?= htmlspecialchars($hike["duration"]); ?> KM</p>
                <p>Elevation gain: <?= htmlspecialchars($hike["elevation_gain"]); ?> KM</p>
                <p>Description: <?= htmlspecialchars($hike["description"]); ?> KM</p>
                <p>Created by: <?= htmlspecialchars($hike["created_by"]); ?> KM</p>
                <p>Created at: <?= htmlspecialchars($hike["created_at"]); ?> KM</p>
                <p>Updated at : <?= htmlspecialchars($hike["updated_at"]); ?> KM</p>

            </div>
        </div>
    <?php endforeach; ?>


<?php 
$contentHeader = "";
$contentBody = "";
$contentFooter = ob_get_clean();
require(__DIR__ . '/../layout.view.php');
?>

