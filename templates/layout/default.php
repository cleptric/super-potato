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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-iKbFRxucmOHIcpWdX9NTZ5WETOPm0Goy0WmfyNcl52qSYtc2Buk0NCe6jU1sWWNB" crossorigin="anonymous">
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
