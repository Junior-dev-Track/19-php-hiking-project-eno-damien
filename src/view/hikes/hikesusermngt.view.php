<?php
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
ob_start();
?>
<form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/add/<?php echo htmlspecialchars($user_id); ?>" method="post">
    <input type="submit" value="Add a Hike">
</form>
<p>Your Hikes List:</p>
<?php if (empty($hikes)) { ?>
    <p>No Hikes found</p>
<?php } else { ?>

    <?php foreach ($hikes as $hikelist) :

        echo $hikelist['name'] ?><br>
        <a href='<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/edit/<?php echo htmlspecialchars($hikelist['id']); ?>' class="mx-2">
            <img src='<?php echo htmlspecialchars(BASE_PATH); ?>/public/images/edit.svg' alt='editicon' style="width: 24px; height: 24px;" />
        </a>
        <a href='<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/delete/<?php echo htmlspecialchars($hikelist['id']); ?>' class="mx-2">
            <img src='<?php echo htmlspecialchars(BASE_PATH); ?>/public/images/delete.svg' alt='deleteicon' style="width: 24px; height: 24px;" />
        </a>
    <?php endforeach; ?>

<?php } ?>

<?php
$contentHeader = "";
$contentBody = ob_get_clean();
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>