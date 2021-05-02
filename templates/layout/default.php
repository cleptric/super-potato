<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->fetch('meta') ?>
    <?= $this->Html->meta('icon') ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <link rel="stylesheet" href="/css/app.css">
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50">
    <?= $this->Flash->render() ?>
    <?= $this->element('layout/menu') ?>
    <?= $this->fetch('content') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
