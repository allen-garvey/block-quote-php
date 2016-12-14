<!DOCTYPE html>

<html lang="en-us" >
    <head>
        <title>Site administration | Block Quote 2 Admin</title>
        <link rel="stylesheet" type="text/css" href="<?= STYLES_URL.'admin.css'; ?>" />
        <meta name="robots" content="NONE,NOARCHIVE" />
    </head>
    <body <?php if(isset($body_class)){ echo "class='$body_class'"; } ?>>

    <!-- Container -->
    <div id="container">
        <!-- Header -->
        <div id="header">
            <div id="branding">
                <h1 id="site-name"><a href="<?= UrlHelper::adminHomeLink(); ?>">Block Quote 2 Administration</a></h1>
            </div>
        </div>
        <!-- END Header -->