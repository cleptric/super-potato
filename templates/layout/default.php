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
    <?= $this->Vite->css('frontend/css/main.js'); ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 min-w-[1024px]">

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

    <script src="https://kit.fontawesome.com/c1157ccfdb.js" crossorigin="anonymous"></script>
    <?= $this->Vite->vite(); ?>
    <?= $this->Vite->script('frontend/js/main.js'); ?>
    <?php if (isset($jsData)): ?>
        <script>
            window.jsData = <?= json_encode($jsData) ?>
        </script>
    <?php endif; ?>
    <?= $this->fetch('script') ?>
</body>
</html>
