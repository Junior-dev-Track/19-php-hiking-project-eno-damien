<?php
ob_start(); ?>

<form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/editcom/<?php echo htmlspecialchars($hikesComments['id_hikes']); ?>/<?php echo htmlspecialchars($hikesComments['id']); ?>" method="post">
  <!-- ?? is usefull to avoid error if the variable is not set, NULL in database replace by empty -->
  <p>FirstName: <?= htmlspecialchars($user_infos[0]["firstname"] ?? ''); ?></p>
  <p>LastName: <?= htmlspecialchars($user_infos[0]["lastname"] ?? ''); ?></p>
  <p>Nickname: <?= htmlspecialchars($user_infos[0]["nickname"] ?? ''); ?></p>
  <p>Email: <?= htmlspecialchars($user_infos[0]["email"] ?? ''); ?></p>
  <input type="submit" value="Edit your profil">
</form>

<?php
$contentHeader = "";
$contentBody = ob_get_clean();
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>