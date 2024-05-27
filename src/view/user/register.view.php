<?php
$user_identifiant = isset($_SESSION['user']['sess_user']) ? $_SESSION['user']['sess_user'] : null;
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
ob_start(); ?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($error) { ?>
        <p><?php echo htmlspecialchars($error) ?></p>
        <!-- id countdownxxx usefull for Javascript redirection -->
        <p>Redirection in <span id="countdownRegister">3</span> seconds</p>
    <?php } else { ?>
        <p>Your registration is successfull.</p>
        <p>Redirection in <span id="countdownIndex">3</span> seconds</p>
    <?php } ?>
    <script>
        sleepRedirection();
    </script>
<?php } else { ?>

    <!-- Affichage du formulaire d'inscription -->
    <form method="post" action="<?php echo BASE_PATH; ?>/sub/verification">
        <label for="nickname">Nickname</label>
        <input type="text" id="nickname" name="nickname" placeholder="nickname" required>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <input type="submit" value="REGISTER">
    </form>
<?php } ?>

<?php
$contentHeader = "";
$contentBody = ob_get_clean();
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>