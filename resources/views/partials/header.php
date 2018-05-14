<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>User Manager</title>
        <link href="app.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <?php if($view->session('success')):?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php print($view->session('success')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if($view->session('old') && isset($view->session("old")["error"])):?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php print($view->session("old")["error"]); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <header>
                <?php $view->import('partials/nav'); ?>
                <?php if(User::isAuth()): ?>
                    <a class="float-right" href="/logout">Logout</a>
                <?php endif; ?>
            </header>
            <main>