<template>
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-900">
                Settings
            </h1>
        </div>
    </header>
    <main>
        <div class="space-y-6 max-w-7xl mx-auto py-7 sm:px-6 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">Change the notification settings</p>
                    </div>

                    <div
                        v-if="message.type && message.text"
                        class="rounded-md p-4 mb-4"
                        :class="{ 'bg-green-50': message.type === 'success', 'bg-red-50': message.type === 'error' }"
                    >
                        <div class="flex">
                            <template v-if="message.type === 'success'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/check-circle -->
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ message.text }}
                                    </p>
                                </div>
                            </template>
                            <template v-if="message.type === 'error'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/x-circle -->
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ message.text }}
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <fieldset
                        v-if="settings.notifications || settings.sounds"
                    >
                        <legend class="text-base font-medium text-gray-900">Try out Notifications</legend>
                        <p class="text-sm text-gray-500">Confirm the settings you assigned below</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center">
                                <button 
                                    class="inline-flex items-center mr-4 px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    @click="triggerNotification"
                                >
                                  Trigger Notification
                                </button>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-base font-medium text-gray-900">Sound Notifications</legend>
                        <p class="text-sm text-gray-500">Sounds are played on missed approaches and closed runways</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center">
                                <input
                                    v-model="settings.sounds"
                                    v-bind:value="true"
                                    id="sounds_all"
                                    name="sounds"
                                    type="radio"
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                >
                                <label for="sounds_all" class="ml-3">
                                    <span class="block text-sm font-medium text-gray-700">All Sounds</span>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input
                                    v-model="settings.sounds"
                                    v-bind:value="false"
                                    id="sound_none"
                                    name="sounds"
                                    type="radio"
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                >
                                <label for="sounds_none" class="ml-3">
                                    <span class="block text-sm font-medium text-gray-700">No Sounds</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset
                        v-if="settings.sounds"
                        class="mt-6"
                    >
                        <legend class="text-base font-medium text-gray-900">Sound Volume</legend>
                        <p class="text-sm text-gray-500">Modify the volume of sounds being played</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center">
                                <input
                                    v-model="settings.volume"
                                    type="range"
                                    min="0"
                                    max="1"
                                    step="0.1"
                                    id="sound_volume"
                                >
                                <label for="sounds_volume" class="ml-3">
                                    <span class="block text-sm font-medium text-gray-700">{{ settings.volume * 100 }}%</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset
                        class="mt-6"
                    >
                        <legend class="text-base font-medium text-gray-900">Browser Notifications</legend>
                        <p class="text-sm text-gray-500">Notifications are shown on missed approaches and closed runways</p>
                        <div class="mt-4 space-y-2">
                            <template v-if="browserNotifications">
                                <div class="flex items-center">
                                    <input
                                        v-model="settings.notifications"
                                        v-bind:value="true"
                                        id="notifications_all"
                                        name="notifications"
                                        type="radio"
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                    >
                                    <label for="notifications_all" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">All Browser Notifications</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        v-model="settings.notifications"
                                        v-bind:value="false"
                                        id="notifications_none"
                                        name="notifications"
                                        type="radio"
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                    >
                                    <label for="notifications_none" class="ml-3">
                                        <span class="block text-sm font-medium text-gray-700">No Browser Notifications</span>
                                    </label>
                                </div>
                            </template>
                            <template v-else>
                                <div class="flex items-center">
                                    <div class="rounded-md bg-blue-50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <!-- Heroicon name: solid/information-circle -->
                                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-blue-800">
                                                    You have to allow Super Potato to send Notifications in your browser settings to enable this feature
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </fieldset>
                </div>
                <div class="bg-white px-4 py-3 sm:px-6">
                    <button 
                        class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600"
                        @click="saveSettings"
                    >
                        Save Settings
                    </button>
                </div>
            </div>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="space-y-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">About</h3>
                        <div>
                            <p class="text-sm text-gray-500">
                                Suport Potato was build with <a href="https://cakephp.org/" target="_blank" rel="noopener" class="underline">CakePHP</a>, <a href="https://vuejs.org/" target="_blank" rel="noopener" class="underline">Vue.js</a> and <a href="https://tailwindcss.com/" target="_blank" rel="noopener" class="underline">Tailwind CSS</a> and many other tools.
                            </p>
                            <p class="text-sm text-gray-500">
                                The source code is available on <a href="https://github.com/cleptric/super-potato" target="_blank" rel="noopener" class="underline">GitHub</a> and is published under the MIT licenese.
                            </p>
                            <p class="text-sm text-gray-500">
                                Special thanks to <span class="text-gray-600">Alex</span>, <span class="text-gray-600">Clemens</span>, <span class="text-gray-600">Mitch</span> &amp; <span class="text-gray-600">Nick</span> for all your help!
                            </p>
                            <p class="mt-2 text-sm text-gray-500">
                                Developed and maintained by <span class="text-gray-600">Michael Hoffmann</span>.
                            </p>
                            <p class="mt-2 text-sm text-gray-400">
                                &#169;Michael Hoffmann - 2021 - Munich, Germany 🏳️‍🌈
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
</template>

<script>
import { computed, ref } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'Settings',
    setup () {
        const store = useStore()
        const browserNotifications = ref(false)
        const message = ref({
            type: null,
            text: null,
        })

        return {
            message: message,
            browserNotifications: browserNotifications,
            settings: computed(() =>store.getters.settings),
        }
    },
    mounted() {
        this.setupNotifications()
    },
    methods: {
        setupNotifications() {
            if (Notification.permission !== 'denied') {
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        this.browserNotifications = true
                    }
                })
            }
            if (Notification.permission === 'granted') {
                this.browserNotifications = true
            }
        },
        triggerNotification() {
            if (this.settings.notifications) {
                new Notification('Hey there 👋')
            }
            if (this.settings.sounds) {
                const audio = new Audio('/sounds/bell.wav')
                audio.volume = this.settings.volume
                audio.play()
            }
        },
        async saveSettings() {
            try {
                await this.$store.dispatch('saveSettings')
                this.message = {
                    type: 'success',
                    text: 'Your settings have been updated',
                }
            } catch (error) {
                this.message = {
                    type: 'error',
                    text: 'Your settings could not be updated',
                }
            } finally {
                setTimeout(() => {
                    this.message = {
                        type: null,
                        text: null,
                    }
                }, 3000)
            }
        },
    },
}
</script>
