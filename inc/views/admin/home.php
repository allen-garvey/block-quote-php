<?php include(ADMIN_VIEWS_PATH.'header.php'); ?>

<body class=" dashboard" data-admin-utc-offset="-18000">

    <!-- Container -->
    <div id="container">
        <!-- Header -->
        <div id="header">
            <div id="branding">
                <h1 id="site-name"><a href="/admin/">Block Quote 2 Administration</a></h1>
            </div>
        </div>
        <!-- END Header -->

        <!-- Content -->
        <div id="content" class="colMS">
            <h1>Site administration</h1>
            <div id="content-main">
                <div class="app-quotes module">
                    <table>
                        <caption>Quotes</caption>
                        <?php foreach ($models as $model):
                            $slug = preg_replace('/\s/', '', strtolower($model));
                         ?>
                            <tr>
                                <th scope="row"><a href="/admin/<?= $slug; ?>/"><?= $model; ?></a></th>
                                <td></td>
                                <td><a href="/admin/?= $slug; ?>/add/" class="addlink">Add</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Content -->
        <div id="footer"></div>
    </div>
    <!-- END Container -->
<?php include(ADMIN_VIEWS_PATH.'footer.php'); ?>


