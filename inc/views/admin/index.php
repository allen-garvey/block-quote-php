<?php include(ADMIN_VIEWS_PATH.'header.php'); ?>
<body class=" app-quotes model-author change-list" data-admin-utc-offset="-18000">
<!-- Container -->
<div id="container">
    <!-- Header -->
    <div id="header">
        <div id="branding">
          <h1 id="site-name"><a href="/admin/">Block Quote 2 Administration</a></h1>
        </div>    
    </div>
    <!-- END Header -->
    
  <div class="breadcrumbs">
    <a href="/admin/">Home</a>
  </div>

    <!-- Content -->
    <div id="content" class="flex">
      <h1>Select <?= $model::name(); ?> to change</h1>
        
      <div id="content-main">
        <ul class="object-tools">
            <li>
              <a href="/admin/<?= $model::slug(); ?>/add/" class="addlink">Add <?= $model::name(); ?></a>
            </li>
        </ul>
        <div class="module" id="changelist">
          <div class="results">
            <table id="result_list">
              <thead>
                <tr>
                <th scope="col"  class="column-__str__">
                   <div class="text"><span><?= $model::displayName(); ?></span></div>
                   <div class="clear"></div>
                </th>
                </tr>
              </thead>
              <tbody>
                <tr class="row1"><th><a href="/admin/quotes/author/271/change/">Example</a></th></tr>
              </tbody>
            </table>
          </div>
          <p class="paginator">
              <span class="this-page">1</span> 
              <a href="?p=1" class="end">2</a> 
            180 authors&nbsp;&nbsp;<a href="?all=1" class="showall">Show all</a>
          </p>
        </div>
      </div>  
    </div>
    <!-- END Content -->
    <div id="footer"></div>
</div>
<!-- END Container -->

<?php include(ADMIN_VIEWS_PATH.'footer.php'); ?>

