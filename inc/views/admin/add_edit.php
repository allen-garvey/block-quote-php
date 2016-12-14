<?php include(ADMIN_VIEWS_PATH.'head.php'); ?>
 
<div class="breadcrumbs"><a href="<?= UrlHelper::adminHomeLink(); ?>">Home</a></div>

<!-- Content -->
<div id="content" class="colM">
    <h1><?php if($context['method'] === UrlHelper::addVerb()){ echo 'Add'; } else{echo 'Change';} ?> <?= htmlentities($model::name()); ?></h1>
    <div id="content-main">
        <form action="" method="POST">
            <div>
                <fieldset class="module aligned ">
                    <?php include(ADMIN_VIEWS_PATH.'forms/'.$model::filename().'.php'); ?>
                </fieldset>
                <div class="submit-row">
                    <input type="submit" value="Save" class="default" name="_save" />
                    <p class="deletelink-box"><a href="/admin/quotes/author/7/delete/" class="deletelink">Delete</a></p>
                    <input type="submit" value="Save and add another" name="_addanother" />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END Content -->

<?php include(ADMIN_VIEWS_PATH.'footer.php'); ?>

