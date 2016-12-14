<div class="form-row">
    <div>
        <label class="required" for="id_author_first">Author first:</label>
        <input class="vTextField" id="id_author_first" name="author_first" type="text" value="<?php echo FormHelper::getValue($context, 'author_first'); ?>" required="required" />
    </div>
</div>

<div class="form-row">
    <div>
        <label for="id_author_middle">Author middle:</label>   
        <input class="vTextField" id="id_author_middle" name="author_middle" type="text" value="<?php echo FormHelper::getValue($context, 'author_middle'); ?>" />
    </div>
</div>

<div class="form-row">
    <div>
        <label for="id_author_last">Author last:</label>   
        <input class="vTextField" id="id_author_last" name="author_last" type="text" value="<?php echo FormHelper::getValue($context, 'author_last'); ?>" />
    </div>
</div>