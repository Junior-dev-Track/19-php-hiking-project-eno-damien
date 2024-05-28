<?php
ob_start(); ?>

<?php if ($action == "editprofil") { ?>
  <form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/saveprofil/<?php echo htmlspecialchars($user_infos[0]["id"]); ?>" method="post">
    <p>FirstName: <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($user_infos[0]['firstname'] ?? ''); ?>"> </p>
    <p>LastName: <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($user_infos[0]['lastname'] ?? ''); ?>"> </p>
    <p>Nickname: <input type="text" name="nickname" id="nickname" value="<?php echo htmlspecialchars($user_infos[0]['nickname'] ?? ''); ?>"> </p>
    <p>Email: <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($user_infos[0]['email'] ?? ''); ?>">
      *Be Carefull : this is your login information </p>
    <input type="submit" value="Save modification">
  </form>

<?php } elseif (($action == "saveprofil") || isset($action)) { ?>
  <form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/showprofil/<?php echo htmlspecialchars($user_infos[0]["id"]); ?>" method="post">
    <!-- ?? is usefull to avoid error if the variable is not set, NULL in database replace by empty -->
    <p>FirstName: <?= htmlspecialchars($user_infos[0]["firstname"] ?? ''); ?></p>
    <p>LastName: <?= htmlspecialchars($user_infos[0]["lastname"] ?? ''); ?></p>
    <p>Nickname: <?= htmlspecialchars($user_infos[0]["nickname"] ?? ''); ?></p>
    <p>Email: <?= htmlspecialchars($user_infos[0]["email"] ?? ''); ?></p>
    <input type="submit" value="Edit your profil">
  </form>
  <form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/deleteprofil/<?php echo htmlspecialchars($user_infos[0]['id']); ?>" method="post">
    <input type="submit" value="Delete your profile">
  </form>
<?php }
$contentHeader = "";
$contentBody = ob_get_clean();
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>