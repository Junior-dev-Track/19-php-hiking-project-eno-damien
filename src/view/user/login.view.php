<?php
ob_start(); ?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($error) { ?>
        <!-- id countdownxxx usefull for Javascript redirection -->
        <p><?php echo htmlspecialchars($error) ?></p>
        <p>Redirection in <span id="countdownLogin">3</span> seconds</p>
    <?php } else { ?>
        <p><?php echo htmlspecialchars($success) ?></p>
        <p>Redirection in <span id="countdownIndex">3</span> seconds</p>
    <?php } ?>
    <script>
        sleepRedirect();
    </script>
<?php
} else { ?>
    <form method="post" action="<?php echo BASE_PATH; ?>/login/verification">
        <label for="email"></label>
        <input type="text" id="email" name="email" placeholder="email" required>

        <label for="password"></label>
        <input type="password" id="password" name="password" placeholder="Password" required></br>

        <input type="submit" class="btn" value="LOGIN">
    </form>
<?php } ?>



<?php $contentBody = ob_get_clean();
$contentHeader = "";
$contentFooter = "";
?>

<?php
//path from dirname, without, error
require(__DIR__ . '/../layout.view.php');
?>