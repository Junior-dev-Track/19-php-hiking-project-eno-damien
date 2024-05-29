<?php
ob_start();
?>
<form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/edit/save/<?php echo htmlspecialchars($hikes[0]["id"]); ?>/<?php echo htmlspecialchars($hikes[0]["created_by"]); ?>" method="post">
    <p>Name: <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($hikes[0]['name'] ?? ''); ?>"> </p>
    <p>Distance: <input type="text" name="distance" id="distance" value="<?php echo htmlspecialchars($hikes[0]['distance'] ?? ''); ?>"> </p>
    <p>Duration: <input type="text" name="duration" id="duration" value="<?php echo htmlspecialchars($hikes[0]['duration'] ?? ''); ?>"> </p>
    <p>Elevation_gain: <input type="text" name="elevation_gain" id="elevation_gain" value="<?php echo htmlspecialchars($hikes[0]['elevation_gain'] ?? ''); ?>">
    <p>Description:
        <textarea style="border:1px solid black" rows="10" cols="100" name="description" id="description"><?php echo htmlspecialchars($hikes[0]['description'] ?? ''); ?></textarea>
    </p>

    <p>Category: <input type="text" name="id_tags" id="id_tags" value="<?php echo htmlspecialchars($hikes[0]['id_tags'] ?? ''); ?>">
        <input type="submit" value="Save modification">
</form>


<?php
$contentHeader = "";
$contentBody = ob_get_clean();
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>