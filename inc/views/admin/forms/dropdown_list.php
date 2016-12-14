<label for="id_<?= $dropdown_name; ?>" <?php if(isset($is_required) && $is_required){ echo 'class="required"'; } ?>><?= htmlentities($model::displayName()); ?>:</label>
<div class="related-widget-wrapper">
    <select id="id_<?= $dropdown_name; ?>" name="<?= $dropdown_name; ?>" <?php if(isset($is_required) && $is_required){ echo 'required="required"'; } ?>>
        <option value="" selected="selected">---------</option>
        <?php foreach($dropdown_items as $dropdown_item): ?>
        	<option value="<?= $dropdown_item['id']; ?>"><?= $model::toHTML($dropdown_item); ?></option>
        <?php endforeach;  ?>
    </select>
</div> 