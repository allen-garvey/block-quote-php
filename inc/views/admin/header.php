<div class="breadcrumbs">
  <a href="<?= UrlHelper::adminHomeLink(); ?>">Home</a>
  <?php if(isset($model)): ?>
  	&rsaquo; <a href="<?= UrlHelper::indexLinkFor($model); ?>"><?= htmlentities($model::displayNamePlural()); ?></a>
  <?php endif; ?>
</div>
<?php if(isset($context['flash']) && $context['flash']):  ?>
	<ul class="messagelist">
		<?php foreach ($context['flash'] as $infoLevel => $message): ?>
  			<li class="<?= FlashController::getFlashClass($infoLevel); ?>"><?= htmlentities($message); ?></li>
  		<?php endforeach; ?>
	</ul>
<?php endif; ?>