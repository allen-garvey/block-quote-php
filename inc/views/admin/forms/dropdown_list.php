<?php 
	if(!isset($selected_id)){
		$selected_id = '';
	}
 ?>

<label for="id_<?= htmlentities($dropdown_name); ?>" <?php if(isset($is_required) && $is_required){ echo 'class="required"'; } ?>><?= FormHelper::labelDisplayName($dropdown_name); ?>:</label>
<div class="related-widget-wrapper">
    <select id="id_<?= htmlentities($dropdown_name); ?>" name="<?= htmlentities($dropdown_name); ?>" <?php if(isset($is_required) && $is_required){ echo 'required="required"'; } ?>>
        <option value="" <?= FormHelper::getSelected($selected_id, ''); ?>>---------</option>
        <?php foreach($dropdown_items as $dropdown_item): ?>
        	<option value="<?= $dropdown_item['id']; ?>" <?= FormHelper::getSelected($selected_id, $dropdown_item['id']); ?>><?= $model::toHTML($dropdown_item); ?></option>
        <?php endforeach;  ?>
    </select>
</div> 