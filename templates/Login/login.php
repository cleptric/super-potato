<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="flex items-center justify-center text-3xl font-extrabold text-gray-900">
            Super <img class="h-7 w-7 ml-2" src="/img/potato.png">
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <?= $this->Flash->render() ?>

            <?= $this->Form->create(null, [
                'class' => 'space-y-6'
            ]); ?>

                <?php if (filter_var(env('DEBUG'), FILTER_VALIDATE_BOOLEAN) === true): ?>
                    <?= $this->Html->link('Vatsim SOO', [
                        'controller' => 'Login',
                        'action' => 'startOauth',
                    ], [
                        'class' => 'w-full flex justify-center py-2 px-4 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
                    ])?>

                    <hr>
                <?php endif; ?>

                <div>
                    <?= $this->Form->label('username', null, [
                        'class' => 'block text-sm font-medium text-gray-700'
                    ]); ?>
                    <?= $this->Form->control('username', [
                        'autocomplete' => 'email',
                        'label' => false,
                        'class' => 'appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                    ]); ?>
                </div>

                <div>
                    <?= $this->Form->label('password', null, [
                        'class' => 'block text-sm font-medium text-gray-700'
                    ]); ?>
                    <?= $this->Form->control('password', [
                        'autocomplete' => 'current-password',
                        'label' => false,
                        'class' => 'appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                    ]); ?>
                </div>

                <div class="!mt-10">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in
                    </button>
                </div>

            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
