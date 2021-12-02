<div class="relative h-full max-w-screen-xl mx-auto flex items-center justify-center">
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8">
        <a href="/">
            <h1 class="flex items-center text-3xl font-extrabold text-gray-900">
                Super <img class="h-7 w-7 ml-2" src="/img/potato.png">
            </h1>
        <a href="/">
    </div>
    <div class="px-4 sm:px-8">
        <div class="mx-auto max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">

                <h2 class="flex items-center text-2xl font-bold text-gray-900">
                    Login
                </h2>

                <div class="leading-tight my-4 text-gray-500">
                    You have to be a member of the RG München to use this service.
                </div>

                <?= $this->Flash->render() ?>

                <?= $this->Form->create(null, [
                    'class' => 'space-y-6',
                ]) ?>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">
                            Username
                        </label>
                        <?= $this->Form->control('username', [
                            'label' => false,
                            'placeholder' => 'jane12',
                            'class' => 'form-input w-full px-4 py-3 leading-4 border-gray-300 rounded-md placeholder-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
                        ]) ?>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <?= $this->Form->control('password', [
                            'label' => false,
                            'placeholder' => '········',
                            'class' => 'form-input w-full px-4 py-3 leading-4 border-gray-300 rounded-md placeholder-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->submit('Login', [
                            'class' => 'w-full flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
                        ]) ?>
                    </div>
                <?= $this->Form->end() ?>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-400">
                            or
                        </span>
                    </div>
                </div>
                <div>
                    <?= $this->Html->link('Sign up', [
                        'action' => 'signup',
                    ], [
                        'class' => 'w-full flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="text-center mt-8">
            <?= $this->Html->link('Imprint', ['action' => 'imprint'], ['class' => 'underline text-sm text-gray-400']) ?>
        </div>
    </div>
</div>
