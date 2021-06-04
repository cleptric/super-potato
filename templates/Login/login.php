<div class="relative h-full max-w-screen-xl mx-auto flex items-center justify-center">
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8">
        <h1 class="flex items-center text-3xl font-extrabold text-gray-900">
            Super <img class="h-7 w-7 ml-2" src="/img/potato.png">
        </h1>
    </div>
    <div class="px-4 sm:px-8">
        <div class="mx-auto max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">

                <h2 class="flex items-center text-2xl font-bold text-gray-900">
                    Servus!
                </h2>

                <div class="leading-tight my-4 text-gray-500">
                    You have to be a member of the <a href="https://www.vacc-austria.org" target="_blank" rel="noopener" class="underline">VACC&nbsp;Austria</a> to use this service.
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
                        // 'class' => 'w-full flex justify-center py-2 px-4 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
                        'class' => 'w-full flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
                    ])?>
                </div>
            </div>
        </div>
        <div class="text-center mt-8">
            <a href="https://www.vacc-austria.org/index.php?page=content/disclaimer&language=en" target="_blank" rel="noopener" class="underline text-sm text-gray-400">
                Imprint
            </a>
        </div>
    </div>
</div>
