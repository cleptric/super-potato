<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            Sign in to your 🥔 account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Or
            <a href="/signup" class="font-medium text-blue-600 hover:text-blue-500">
                sign up
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <?= $this->Flash->render() ?>

            <?= $this->Form->create(null, [
                'class' => 'space-y-6'
            ]); ?>

                <div>
                    <?= $this->Form->label('username', null, [
                        'class' => 'block text-sm font-medium text-gray-700'
                    ]); ?>
                    <?= $this->Form->control('username', [
                        'autocomplete' => 'email',
                        'label' => false,
                        'autofocus',
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

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in
                    </button>
                </div>

            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
