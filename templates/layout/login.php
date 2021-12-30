<!DOCTYPE html>
<html class="h-full">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->fetch('meta') ?>
    <?= $this->Html->meta('icon') ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->element('assets') ?>
    <?= $this->fetch('script') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 dark:bg-zinc-900 text-gray-900 dark:text-zinc-100 h-full w-full">
    <?= $this->fetch('content') ?>
</body>
</html>
