<!DOCTYPE html>
<html class="h-full">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->fetch('meta') ?>
    <?= $this->Html->meta('icon') ?>
    <title>Super Potato</title>
    <?= $this->Html->script('https://kit.fontawesome.com/c1157ccfdb.js', [
        'crossorigin' => 'anonymous',
    ]) ?>

    <?= $this->element('assets') ?>
    <?= $this->fetch('script') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 h-full w-full">
    <?= $this->fetch('content') ?>
</body>
</html>
