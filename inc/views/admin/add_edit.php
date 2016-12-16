<?php 
    include(ADMIN_VIEWS_PATH.'head.php'); 
    include(ADMIN_VIEWS_PATH.'header.php');
?>

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
                    <?php if($context['method'] === UrlHelper::editVerb()): ?>
                        <p class="deletelink-box"><button type="button" class="deletelink" data-button="delete">Delete</button></p>
                    <?php endif; ?>
                    <input type="submit" value="Save and add another" name="_addanother" />
                </div>
            </div>
        </form>
    </div>
</div>
<?php if($context['method'] === UrlHelper::editVerb()): ?>
    <form action="<?= UrlHelper::deleteLinkFor($model); ?>" method="POST" id="delete_form">
        <input type="hidden" name="id" value="<?= $context['item']['id']; ?>" />
    </form>
    <script>
        //add delete action to delete button
        document.querySelector('[data-button="delete"]').onclick = function(){
            var shouldDelete = confirm("Are you sure you want to delete this item?");
            if(!shouldDelete){
                return;
            }
            document.getElementById('delete_form').submit();
        };
    </script>
<?php endif; ?>
<!-- END Content -->

<?php include(ADMIN_VIEWS_PATH.'footer.php'); ?>

