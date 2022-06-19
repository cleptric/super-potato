<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $jsData
 */
?>
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

    <?= $this->element('assets') ?>

    <?php if (isset($jsData)): ?>
        <script>
            window.jsData = <?= json_encode($jsData) ?>
        </script>
    <?php endif; ?>

    <?= $this->fetch('script') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 dark:bg-zinc-900 text-gray-900 dark:text-zinc-100 min-w-[1024px]">
    <div id="app">
        <!-- Content is replaced by the vue app -->
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
                <a href="/" class="flex items-center text-2xl font-extrabold">
                    Super <img class="h-7 w-7 ml-2" src="/img/potato.png">
                </a>
                <span class="text-gray-500 text-sm">Loading...</span>
            </div>
        </div>
    </div>
</body>
</html>
