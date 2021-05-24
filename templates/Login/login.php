<div class="min-h-screen bg-gray-50 pt-[10%] py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="flex items-center justify-center text-3xl font-extrabold text-gray-900">
            Super <img class="h-7 w-7 ml-2" src="/img/potato.png">
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <?= $this->Flash->render() ?>

            <div class="space-y-6">
                <?= $this->Html->link('Vatsim SSO', [
                    'controller' => 'Login',
                    'action' => 'startOauth',
                ], [
                    'class' => 'w-full flex justify-center py-2 px-4 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
                ])?>
            </div>
        </div>
    </div>
</div>
