<template>
    <header class="bg-gray-700 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center py-2 px-4 sm:px-6 lg:px-8">
            <div class="ml-auto px-2 rounded-md text-sm font-medium text-gray-400 bg-gray-600 hover:bg-gray-800 hover:text-white">
                <a href="/logout" class="flex items-center">
                    <i class="far fa-sign-out text-xs text-gray-300 mr-1"></i> Sign out
                </a>
            </div>
        </div>
    </header>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex items-center justify-between h-12 xl:h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center text-white text-2xl font-extrabold">
                            Super <img class="h-7 w-7 ml-2" :src="logoUrl">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="pt-[25%] mb-2 text-2xl text-center font-semibold">
            Looks like the Super Potato is broken behind repair
        </h1>
        <p class="mb-16 text-center text-sm text-gray-500 italic">
            Ois Oasch hoid...
        </p>
        <div class="text-center">
            <a href="/" class="py-2 px-4 border border-blue-300 rounded-md shadow-sm text-center text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Refresh page
            </a>
        </div>
    </div>
</template>

<script>

export default {
    name: 'OisOasch',
    setup () {
        return {
            logoUrl: '/img/potato.png',
        }
    },
}
</script>