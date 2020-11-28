<?php
require './config.php';
require './models/Auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'home';

require './partials/header.php';
require './partials/menu.php';
?>

<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">

            <?php
            require './partials/feed-new.php';
            ?>




        </div>
        <div class="column side pl-5">
            <?php
            require './partials/banners.php';
            ?>
        </div>
    </div>
</section>

<?php
require './partials/footer.php'
?>