<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('Author', $context[Author::filename()], 'author');
        ?>   
    </div>
</div>
    
<div class="form-row">
    <div>
        <label class="required" for="id_title">Title:</label>
        <input class="vTextField" id="id_title" name="title" type="text" required="required" value="<?php echo FormHelper::getValue($context, 'title'); ?>" />
    </div>
</div>
    
<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $is_required){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('SourceType', $context[SourceType::filename()], 'source_type', true);
        ?>            
    </div>
</div>
    
<div class="form-row">
    <div>
        <label for="id_release_date">Release date:</label>
        <input class="vDateField" id="id_release_date" name="release_date" size="10" type="date" value="<?php echo FormHelper::getValue($context, 'release_date'); ?>" />
    </div>
</div>

<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('Source', $context[Source::filename()], 'parent_source');
        ?>
    </div>     
</div>
    
<div class="form-row">
    <div>
        <label for="id_url">Url:</label>
        <input class="vTextField" id="id_url" name="url" type="text" value="<?php echo FormHelper::getValue($context, 'url'); ?>" />
    </div>
</div>
   