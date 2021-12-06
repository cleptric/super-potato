<div class="relative h-full max-w-screen-xl mx-auto flex items-center justify-center">
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8">
        <a href="">
            <h1 class="flex items-center text-3xl font-extrabold text-gray-900">
                Super <img class="h-7 w-7 ml-1" src="/img/potato.png">
            </h1>
        </a>
    </div>
    <div class="px-4 sm:px-8">
        <div class="mx-auto max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">

                <h2 class="flex items-center text-2xl font-bold text-gray-900">
                    Hey there!
                </h2>

                <div class="leading-tight my-4 text-gray-500">
                    You need to be a member of the <a href="https://vatsim.net" target="_blank" rel="noopener" class="underline">VATSIM&nbsp;Network</a> to use this service.
                </div>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-400">
                            Continue with
                        </span>
                    </div>
                </div>

                <?= $this->Flash->render() ?>

                <div>
                    <?= $this->Html->link('Vatsim SSO', [
                        'controller' => 'Login',
                        'action' => 'startOauth',
                    ], [
                        'class' => 'button button-full button-primary'
                    ])?>
                </div>
            </div>
        </div>
        <div class="flex justify-center text-sm text-gray-400 mt-8">
            <?= $this->Html->link('Imprint', ['action' => 'imprint'], ['class' => 'underline']) ?>
            <span class="mx-2">&middot;</span>
            <?= $this->Html->link('Privacy Policy', ['action' => 'privacy-policy'], ['class' => 'underline']) ?>
        </div>
    </div>
</div>
