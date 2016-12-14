<?php 
	if(!isset($is_required)){
		$is_required = false;
	}
	if(!isset($input_type)){
		$input_type = 'text';
	}
 ?>

<label <?= FormHelper::getRequiredClass($is_required); ?> for="id_<?= htmlentities($input_name); ?>"><?= FormHelper::labelDisplayName($input_name); ?>:</label>
<input class="vTextField" id="id_<?= htmlentities($input_name); ?>" name="<?= htmlentities($input_name); ?>" type="<?= $input_type; ?>" <?= FormHelper::getRequired($is_required); ?> value="<?= $input_value; ?>" />