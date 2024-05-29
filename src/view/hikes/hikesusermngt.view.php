<?php
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
ob_start();
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 max-w-xl">
    <form action="<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/add/<?php echo htmlspecialchars($user_id); ?>" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <p class="block text-gray-700 text-2xl font-bold mb-2">Your Hikes List:</p>
        <?php if (empty($hikes)) { ?>
            <p class="block text-gray-700 text-2xl font-bold mb-2">No Hikes found</p>
        <?php } else { ?>
            <?php foreach ($hikes as $hikelist) : ?>
                <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-4">
                    <p class="block text-gray-700 text-2xl font-bold mb-2"><?php echo $hikelist['name'] ?></p>
                    <div class="flex">
                        <a href='<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/edit/<?php echo htmlspecialchars($hikelist['id']); ?>' class="mx-2">
                            <img src='<?php echo htmlspecialchars(BASE_PATH); ?>/public/images/edit.svg' alt='editicon' style="width: 24px; height: 24px;" />
                        </a>
                        <a href='<?php echo htmlspecialchars(BASE_PATH); ?>/user/hikesmngt/delete/<?php echo htmlspecialchars($hikelist['id']); ?>' class="mx-2">
                            <img src='<?php echo htmlspecialchars(BASE_PATH); ?>/public/images/delete.svg' alt='deleteicon' style="width: 24px; height: 24px;" />
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } ?>
        <input class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Add a Hike">
    </form>
</div>

<?php
$contentBody = ob_get_clean();
$contentHeader = "";
$contentFooter = "";
require(__DIR__ . '/../layout.view.php');
?>