 <div class="form-row">
    <div>
        <label class="required" for="id_quote_content">Quote content:</label>
        <textarea class="vLargeTextField" cols="40" id="id_quote_content" name="quote_content" rows="10" required="required"><?php echo FormHelper::getValue($context, 'quote_content'); ?></textarea>
    </div>
</div>

<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $is_required, $selected_id){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('QuoteGenre', $context[QuoteGenre::filename()], 'genre_id', true, FormHelper::getValue($context, 'genre_id'));
        ?>
    </div>     
</div>

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
            (function($model, $dropdown_items, $dropdown_name, $is_required, $selected_id){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('Source', $context[Source::filename()], 'source', true, FormHelper::getValue($context, 'source_id'));
        ?>
    </div>     
</div>
