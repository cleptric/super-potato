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
    <?= $this->Html->script('https://kit.fontawesome.com/c1157ccfdb.js', [
        'crossorigin' => 'anonymous',
    ]) ?>

    <?= $this->Vite->css('frontend/main.js') ?>

    <?php if (isset($jsData)): ?>
        <script>
            window.jsData = <?= json_encode($jsData) ?>
        </script>
    <?php endif; ?>

    <?= $this->fetch('script') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 min-w-[1024px]">
    <?= $this->fetch('content') ?>
</body>
</html>
