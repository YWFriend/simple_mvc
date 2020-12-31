<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
</head>
<body>

    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

    <h1>Tasks</h1>

    <?php
        if ($tasks):
        foreach ($tasks as $t): 
    ?>

    <article>
        <header>
            <h1><a href="/tasks/details/<?php echo $t['id']; ?>"><?php echo $t['title']; ?></a></h1>
            <p><?php echo $t['user_name']; ?></p>
            <p>Published on: <time pubdate="pubdate"><?php echo $t['timestamp']; ?></time></p>
        </header>
        <p><a href="/tasks/details/<?php echo $t['id']; ?>">Open</a></p>
        <hr/>
    </article>
    <?php
        endforeach;
        else: 
    ?>

    <h1>Welcome!</h1>
    <p>We currently do not have any tasks.</p>

    <?php endif; ?>

</body>
</html>