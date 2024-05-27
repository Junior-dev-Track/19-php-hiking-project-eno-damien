<?php
ob_start();
$user_identifiant = isset($_SESSION['user']['sess_user']) ? $_SESSION['user']['sess_user'] : null;
$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
?>
<div class="min-h-screen bg-gray-900 flex flex-col  relative px-4">
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center" style="background-image: url('<?php echo BASE_PATH; ?>/public/images/background.jpeg');">
    </div>

    <div class="bg-gray-900 opacity-100">
            <div class="max-w-screen-xl mx-auto pt-5 sm:pt-10 md:pt-16 relative">
                <!-- Display the main image -->
                <div class="bg-cover bg-center text-center overflow-hidden" style="min-height: 500px; background-image: url('<?php echo BASE_PATH; ?>/public/images/<?php echo htmlspecialchars($hike["id"] ?? 'default'); ?>.jpg')" title="<?= htmlspecialchars($hike['name']); ?>">
                </div>
                <div class="max-w-3xl mx-auto">
                    <div class="mt-3 bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
                        <div class="bg-white relative top-0 -mt-32 p-5 sm:p-10">
                            <h1 class="text-gray-900 font-bold text-3xl mb-2"><?= htmlspecialchars($hike['name']); ?></h1>
                            <p class="text-gray-700 text-xs mt-2">Written By:
                                <a href="#" class="text-indigo-600 font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                                    <?= htmlspecialchars($hike["created_by"]); ?>
                                </a> In
                                <a href="#" class="text-xs text-indigo-600 font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                                    Hiking
                                </a>
                            </p>

                            <p class="text-base leading-8 my-5">
                                <strong>Distance:</strong> <?= htmlspecialchars($hike["distance"]); ?> KM<br>
                                <strong>Duration:</strong> <?= htmlspecialchars($hike["duration"]); ?> Hours<br>
                                <strong>Elevation gain:</strong> <?= htmlspecialchars($hike["elevation_gain"]); ?> M<br>
                                <strong>Description:</strong> <?= htmlspecialchars($hike["description"]); ?><br>
                                <strong>Created at:</strong> <?= htmlspecialchars($hike["created_at"]); ?><br>
                                <strong>Updated at :</strong> <?= htmlspecialchars($hike["updated_at"]); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Comment form -->
            <?php if (!empty($user_identifiant)) { ?>
                <div class="max-w-screen-xl mx-auto pb-5 sm:pb-10 md:pb-16 relative">
                    <div class="max-w-3xl mx-auto">
                        <div class="mt-3 bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
                            <div class="bg-white p-5 sm:p-10">
                                <h2 class="text-2xl font-bold mb-4">Comments Section</h2>
                                <?php $commentHike_compteur = 1;
                                foreach ($hikesComments_array as $hcomment) { ?>
                                    <div class="my-4 p-4 bg-gray-100 rounded shadow">
                                        <h2 class="font-bold text-lg mb-2">Comment (n°<?= $commentHike_compteur ?>):</h2>
                                        <p class="text-gray-700"><?= $hcomment['hikes_comments'] ?></p>
                                        <?php // The user can delete his own comments
                                        if (($user_id) == $hcomment['id_user']) { ?>
                                            <div class="mt-2">
                                                <!-- Keep the code and id to be able to return to the page product after action -->
                                                <a href='<?php echo htmlspecialchars(BASE_PATH); ?>/hikes/editcom/<?= $hike['id']; ?>/<?= $hcomment['id'] ?>'><img src='<?php echo htmlspecialchars(BASE_PATH); ?>/public/images/edit-icon.png' alt='editicon' /></a>
                                                <a href='<?php echo htmlspecialchars(BASE_PATH); ?>/hikes/deletecom/<?= $hike['id']; ?>/<?= $hcomment['id'] ?>'><img src='<?php echo htmlspecialchars(BASE_PATH); ?>/public/images/delete-icon.png' alt='deleteicon' /></a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    $posted_date = new DateTime($hcomment['posted_at']);
                                    $formatted_date = $posted_date->format("F d, Y - H\hi"); ?>
                                    <div class="mt-2 text-sm text-gray-600">Posted by: <?= $hcomment['nickname'] . " (" . $formatted_date . ")" ?></div>
                                <?php $commentHike_compteur++;
                                } ?>
                                <?php if ($error_com) { ?>
                                    <div class="mt-2 text-red-600"><?php echo htmlspecialchars($error_com) ?></div>
                                <?php } else if ($success_com) { ?>
                                    <div class="mt-2 text-green-600"><?php echo htmlspecialchars($success_com) ?></div>
                                <?php } ?>
                                <div class="mt-4">
                                    <label for="productComment" class="block text-gray-700 text-sm font-bold mb-2">Leave a new comment:</label>
                                    <!-- Comment form -->
                                    <form action="<?php echo BASE_PATH; ?>/hikes/addcomment/<?= $hike["id"]; ?>/<?= $user_id; ?>" method="post">
                                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="5" name="hikesComment" id="hikeComment"></textarea>
                                        <input type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" value="Post your comment">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 relative">
                    <div class="max-w-3xl mx-auto">
                        <div class="mt-3 bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
                            <div class="bg-white p-5 sm:p-10">
                                <div class="text-gray-700 text-center py-4">You have to be logged in to see and post comment(s).</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            $contentHeader = "";
            $contentBody = "";
            $contentFooter = ob_get_clean();
            require(__DIR__ . '/../layout.view.php');
            ?>