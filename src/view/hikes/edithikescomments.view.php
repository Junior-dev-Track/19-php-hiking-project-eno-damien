<?php ob_start(); ?>
    <?php if (is_array($hikesComments)) { ?>
        <label for="hikesComment">Edit your comment :</label>
        <!-- Comment form -->
        <?php echo 'Action URL: ' . htmlspecialchars(BASE_PATH) . '/hikes/editcom/'; ?>
        <form action="<?php echo htmlspecialchars(BASE_PATH); ?>/hikes/editcom/<?php echo htmlspecialchars($hike['id']); ?>/<?php echo htmlspecialchars($hikesComments['id']); ?>" method="post">
            <textarea style="border:1px solid black" rows="5" cols="50" name="hikesComment" id="hikesComment"><?php echo htmlspecialchars($hikesComments['hikes_comments']); ?></textarea>
            <input type="submit" value="Edit your comment">
        </form>
    <?php } else { ?>
        <p>It seems the product number you entered doesn't exist.</p>
    <?php } ?>
<?php $contentBody = ob_get_clean();
$contentHeader = "";
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>



