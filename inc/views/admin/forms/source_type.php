<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value, $is_required){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('name', FormHelper::getValue($context, 'name'), true);
        ?>
    </div>
</div>