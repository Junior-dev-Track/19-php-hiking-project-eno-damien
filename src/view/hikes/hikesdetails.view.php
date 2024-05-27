<?php
ob_start();
$user_identifiant = isset($_SESSION['user']['sess_user']) ? $_SESSION['user']['sess_user'] : null;
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
?>

<?php foreach ($hikesDetails_array as $hike) : ?>
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
<!-- Hikes Comments list and form -->
<?php if (!empty($user_identifiant)) { ?>
    <?php $commentHike_compteur = 1;
    foreach ($hikesComments_array as $hcomment) { ?>
        <div>
            <div>Comment (n°<?= $commentHike_compteur ?>) :</div>
            <div><?= $hcomment['hikes_comments'] ?></div>
            <?php // The use can delete is own comments
            if (($user_id) == $hcomment['id_user']) { ?>
                <div>
                    <!-- Keep the code and id to be able to return to the page product after action -->
                    <a href='<?php echo BASE_PATH; ?>/hikes/editcom/<?= $hike['id']; ?>/<?= $hcomment['id'] ?>'><img src='<?php echo BASE_PATH; ?>/public/images/edit-icon.png' alt='editicon' /></a>
                </div>
                <div>
                    <a href='<?php echo BASE_PATH; ?>/hikes/deletecom/<?= $hike['id']; ?>/<?= $hcomment['id'] ?>'><img src='<?php echo BASE_PATH; ?>/public/images/delete-icon.png' alt='deleteicon' /></a>
                </div>
            <?php } ?>
        </div>
        <?php
        $posted_date = new DateTime($hcomment['posted_at']);
        $formatted_date = $posted_date->format("F d, Y - H\hi"); ?>
        <div>
            <div>Posted by :</div>
            <div><?= $hcomment['nickname'] . " (" . $formatted_date . ")" ?></div>
        </div>
        <div></div>
    <?php $commentHike_compteur++;
    } ?>
    <?php if ($error_com) { ?>
        <div>
            <div></div>
            <div><?php echo htmlspecialchars($error_com) ?></div>
        </div>
    <?php } else if ($success_com) { ?>
        <div>
            <div></div>
            <div><?php echo htmlspecialchars($success_com) ?></div>
        </div>
    <?php } ?>
    <div>
        <div>
            <label for="productComment">Leave a new comment :</label>
        </div>
        <!-- Comment form -->
        <form action="<?php echo BASE_PATH; ?>/hikes/addcomment/<?= $hike["id"]; ?>/<?= $user_id; ?>" method="post">
            <div>
                <textarea style="border:1px solid black" rows="5" cols="50" name="hikesComment" id="hikeComment"></textarea>
            </div>
            <input type="submit" class="btn_post" value="Post your comment">
        </form>
    </div>
<?php } else { ?>
    <di>
        <div>Comment :</div>
        <div>You have to be logged in to see and post comment(s).</div>
        </div>
    <?php } ?>


    <?php
    $contentHeader = "";
    $contentBody = "";
    $contentFooter = ob_get_clean();
    require(__DIR__ . '/../layout.view.php');
    ?>