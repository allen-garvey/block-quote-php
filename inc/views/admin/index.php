<?php include(ADMIN_VIEWS_PATH.'header.php'); ?>
<body class=" app-quotes model-author change-list" data-admin-utc-offset="-18000">
<!-- Container -->
<div id="container">
    <!-- Header -->
    <div id="header">
        <div id="branding">
          <h1 id="site-name"><a href="<?= UrlHelper::adminHomeLink(); ?>">Block Quote 2 Administration</a></h1>
        </div>    
    </div>
    <!-- END Header -->
    
  <div class="breadcrumbs">
    <a href="<?= UrlHelper::adminHomeLink(); ?>">Home</a>
  </div>

    <!-- Content -->
    <div id="content" class="flex">
      <h1>Select <?= htmlentities($model::name()); ?> to change</h1>
        
      <div id="content-main">
        <ul class="object-tools">
            <li>
              <a href="<?= UrlHelper::addLinkFor($model); ?>" class="addlink">Add <?= htmlentities($model::name()); ?></a>
            </li>
        </ul>
        <div class="module" id="changelist">
          <div class="results">
            <table id="result_list">
              <thead>
                <tr>
                <th scope="col"  class="column-__str__">
                   <div class="text"><span><?= htmlentities($model::displayName()); ?></span></div>
                   <div class="clear"></div>
                </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($context['items'] as $item): ?>
                  <tr><th><a href="<?= UrlHelper::editLinkFor($model, $item['id']); ?>"><?= htmlentities($model::toString($item)); ?></a></th></tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <p class="paginator">
            <?php 
              if($context['num_pages'] > 1):
                for($i=1;$i<= $context['num_pages'];$i++):
                  if($i == $context['current_page']){
                    echo "<span class='this-page'>$i</span>";
                  }
                  else{
                    echo "<a href='?p=$i' class='end'>$i</a>";
                  }
                endfor;
              endif;
            ?>
            <?= $context['items_count'].' '.htmlentities($model::namePlural()); ?>
            <?php if($context['num_pages'] > 1): ?>
              &nbsp;&nbsp;<a href="?p=-1" class="showall">Show all</a>
            <?php endif; ?>
          </p>
        </div>
      </div>  
    </div>
    <!-- END Content -->
    <div id="footer"></div>
</div>
<!-- END Container -->

<?php include(ADMIN_VIEWS_PATH.'footer.php'); ?>

