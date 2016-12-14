<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value, $is_required){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('author_first', FormHelper::getValue($context, 'author_first'), true);
        ?>
    </div>
</div>

<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('author_middle', FormHelper::getValue($context, 'author_middle'));
        ?>
    </div>
</div>

<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('author_last', FormHelper::getValue($context, 'author_last'));
        ?>
    </div>
</div>