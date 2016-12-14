<div class="breadcrumbs">
  <a href="<?= UrlHelper::adminHomeLink(); ?>">Home</a>
  <?php if(isset($model)): ?>
  	&rsaquo; <a href="<?= UrlHelper::indexLinkFor($model); ?>"><?= htmlentities($model::displayNamePlural()); ?></a>
  <?php endif; ?>
</div>
<ul class="messagelist">
  <li class="success">The source type "test" was deleted successfully</li>
</ul>