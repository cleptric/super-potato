<template>
    <nav class="bg-gray-200">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex items-center justify-between h-12 xl:h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center text-2xl font-extrabold">
                            Super <img class="h-7 w-7 ml-1" :src="logoUrl">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="pt-[25%] mb-2 text-2xl text-center font-semibold">
            Looks like Super Potato is broken beyond repair
        </h1>
        <p class="mb-16 text-center text-sm text-gray-500 italic">
            Ois Oasch hoid...
        </p>
        <div class="text-center">
            <a href="/" class="button button-primary">
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