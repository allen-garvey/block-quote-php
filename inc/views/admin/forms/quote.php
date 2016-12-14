 <div class="form-row">
    <div>
        <label class="required" for="id_quote_content">Quote content:</label>
        <textarea class="vLargeTextField" cols="40" id="id_quote_content" name="quote_content" rows="10" required="required"><?php echo FormHelper::getValue($context, 'quote_content'); ?></textarea>
    </div>
</div>

<div class="form-row">
    <div>
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $is_required){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('QuoteGenre', $context[QuoteGenre::filename()], 'quote_genre', true);
        ?>
    </div>     
</div>

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
        <?php 
            (function($model, $dropdown_items, $dropdown_name, $is_required){
                include(ADMIN_VIEWS_PATH.'forms/dropdown_list.php');
            })('Source', $context[Source::filename()], 'source', true);
        ?>
    </div>     
</div>
