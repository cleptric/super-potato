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
    <?= $this->Vite->vite(); ?>
    <?= $this->Vite->css('frontend/css/main.js'); ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 h-full w-full">
    <?= $this->fetch('content') ?>
</body>
</html>
