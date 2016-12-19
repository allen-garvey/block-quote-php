<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $selected_id){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('Author', $context[Author::filename()], 'author_id', FormHelper::getValue($context, 'author_id'));
        ?>   
    </div>
</div>
    
<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value, $is_required){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('title', FormHelper::getValue($context, 'title'), true);
        ?>
    </div>
</div>
    
<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $is_required, $selected_id){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('SourceType', $context[SourceType::filename()], 'source_type_id', true, FormHelper::getValue($context, 'source_type_id'));
        ?>            
    </div>
</div>
    
<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value, $input_type){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('release_date', FormHelper::getValue($context, 'release_date'), 'date');
        ?>
    </div>
</div>

<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $selected_id){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('Source', $context[Source::filename()], 'parent_source_id', FormHelper::getValue($context, 'parent_source_id'));
        ?>
    </div>     
</div>
    
<div class="form-row">
    <div>
        <?php
            (function($input_name, $input_value, $input_type){
                include(ADMIN_VIEWS_PATH.'forms/text_input.php');
            })('url', FormHelper::getValue($context, 'url'), 'url');
        ?>
    </div>
</div>
   