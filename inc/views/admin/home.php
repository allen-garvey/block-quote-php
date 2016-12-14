<?php 
    (function($body_class){
        include(ADMIN_VIEWS_PATH.'head.php');
    })('dashboard');
?>
    <!-- Content -->
    <div id="content" class="colMS">
        <h1>Site administration</h1>
        <div id="content-main">
            <div class="app-quotes module">
                <table class="admin-main-menu-table">
                    <caption>Quotes</caption>
                    <?php foreach ($models as $model): ?>
                        <tr>
                            <th scope="row"><a href="<?= UrlHelper::indexLinkFor($model); ?>"><?= htmlentities($model::displayNamePlural()); ?></a></th>
                            <td></td>
                            <td><a href="<?= UrlHelper::addLinkFor($model); ?>" class="addlink">Add</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <!-- END Content -->
<?php include(ADMIN_VIEWS_PATH.'footer.php'); ?>


