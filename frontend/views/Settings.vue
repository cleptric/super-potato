<template>
    <main>
        <div class="max-w-7xl mx-auto px-8">
            <div class="mt-3 rounded-md bg-white dark:bg-zinc-900 overflow-hidden border border-gray-200 dark:border-zinc-600">
                <div class="p-3 space-y-6">
                    <div
                        v-if="message.type && message.text"
                        class="rounded-md p-3"
                        :class="{ 'bg-green-50': message.type === 'success', 'bg-red-50': message.type === 'error' }"
                    >
                        <div class="flex">
                            <template v-if="message.type === 'success'">
                                <div class="shrink-0">
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
                                <div class="shrink-0">
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
                        <legend class="text-base font-medium">Try out Notifications</legend>
                        <p class="text-sm text-gray-500 dark:text-zinc-300">Confirm the settings you assigned below</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center">
                                <button 
                                    class="button button-secondary"
                                    @click="triggerNotification"
                                >
                                  Trigger Notification
                                </button>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-base font-medium">Sound Notifications</legend>
                        <p class="text-sm text-gray-500 dark:text-zinc-300">Sounds are played on missed approaches and closed runways</p>
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
                                    <span class="block text-sm font-medium text-gray-700 dark:text-zinc-300">All Sounds</span>
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
                                    <span class="block text-sm font-medium text-gray-700 dark:text-zinc-300">No Sounds</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset
                        v-if="settings.sounds"
                    >
                        <legend class="text-base font-medium">Sound Volume</legend>
                        <p class="text-sm text-gray-500 dark:text-zinc-300">Modify the volume of sounds being played</p>
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
                                    <span class="block text-sm font-medium text-gray-700 dark:text-zinc-300">{{ settings.volume * 100 }}%</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="text-base font-medium">Browser Notifications</legend>
                        <p class="text-sm text-gray-500 dark:text-zinc-300">Notifications are shown on missed approaches and closed runways</p>
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
                                        <span class="block text-sm font-medium text-gray-700 dark:text-zinc-300">All Browser Notifications</span>
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
                                        <span class="block text-sm font-medium text-gray-700 dark:text-zinc-300">No Browser Notifications</span>
                                    </label>
                                </div>
                            </template>
                            <template v-else>
                                <div class="flex items-center">
                                    <div class="rounded-md bg-blue-50 p-3">
                                        <div class="flex">
                                            <div class="shrink-0">
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
                    <button 
                        class="button button-primary"
                        @click="saveSettings"
                    >
                        Save Settings
                    </button>
                </div>
            </div>
            <div class="mt-3 rounded-md bg-white dark:bg-zinc-900 overflow-hidden border border-gray-200 dark:border-zinc-600">
                <div class="p-3 space-y-6">
                    <fieldset>
                        <legend class="text-base font-medium">Choose your Theme</legend>
                        <p class="text-sm text-gray-500 dark:text-zinc-300">A Light or Dark Theme is available</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center">
                                <div
                                    class="relative w-48 h-20 cursor-pointer rounded-md bg-gray-50 border border-gray-200 dark:border-zinc-600 space-y-2 p-3"
                                    @click="setLightTheme"
                                >
                                    <div class="h-2 w-3/4 bg-gray-200 rounded-full"></div>
                                    <div class="h-2 bg-gray-900 rounded-full"></div>
                                    <div class="h-2 bg-gray-900 rounded-full"></div>
                                    <div class="h-2 bg-gray-900 rounded-full"></div>
                                    <span
                                        v-if="theme === 'light'"
                                        class="fa-stack fa-xs absolute bottom-1 right-1"
                                    >
                                        <i class="fas fa-circle fa-stack-2x text-blue-500"></i>
                                        <i class="fas fa-check fa-stack-1x text-white"></i>
                                    </span>
                                </div>
                                <div class="mx-1.5"></div>
                                <div
                                    class="relative w-48 h-20 cursor-pointer rounded-md bg-zinc-900 border border-gray-200 dark:border-zinc-600 space-y-2 p-3"
                                    @click="setDarkTheme"
                                >
                                    <div class="h-2 w-3/4 bg-zinc-800 rounded-full"></div>
                                    <div class="h-2 bg-zinc-100 rounded-full"></div>
                                    <div class="h-2 bg-zinc-100 rounded-full"></div>
                                    <div class="h-2 bg-zinc-100 rounded-full"></div>
                                    <span
                                        v-if="theme === 'dark'"
                                        class="fa-stack fa-xs absolute bottom-1 right-1"
                                    >
                                        <i class="fas fa-circle fa-stack-2x text-blue-500"></i>
                                        <i class="fas fa-check fa-stack-1x text-white"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="mt-3 rounded-md bg-white dark:bg-zinc-900 overflow-hidden border border-gray-200 dark:border-zinc-600 p-3 space-y-6">
                    <div class="space-y-2">
                        <fieldset>
                            <legend class="text-base font-medium">Delete Account</legend>
                            <p class="text-sm text-gray-500 dark:text-zinc-300">If you do not longer want to use Super Potato, you can delete your account</p>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center">
                                    <button 
                                        class="button button-secondary"
                                        @click="toggleDeleteAccount"
                                    >
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="mt-3 rounded-md bg-white dark:bg-zinc-900 overflow-hidden border border-gray-200 dark:border-zinc-600">
                <div class="p-3 space-y-6">
                    <fieldset>
                        <legend class="text-base font-medium">About</legend>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-zinc-300">
                                Super Potato was build with <a href="https://cakephp.org/" target="_blank" rel="noopener" class="underline">CakePHP</a>, <a href="https://vuejs.org/" target="_blank" rel="noopener" class="underline">Vue.js</a> and <a href="https://tailwindcss.com/" target="_blank" rel="noopener" class="underline">Tailwind CSS</a> and many other tools.
                            </p>
                            <p class="text-sm text-gray-500 dark:text-zinc-300">
                                The source code is available on <a href="https://github.com/cleptric/super-potato" target="_blank" rel="noopener" class="underline">GitHub</a> and is published under the MIT license.
                            </p>
                            <p class="text-sm text-gray-500 dark:text-zinc-300">
                                Special thanks to <span class="text-gray-600 dark:text-zinc-400">Alex</span>, <span class="text-gray-600 dark:text-zinc-400">Clemens</span>, <span class="text-gray-600 dark:text-zinc-400">Mitch</span> &amp; <span class="text-gray-600 dark:text-zinc-400">Nick</span> for all your help!
                            </p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-zinc-300">
                                Developed and maintained by <span class="text-gray-600 dark:text-zinc-400">Michael Hoffmann</span> and <span class="text-gray-600 dark:text-zinc-400">Luis Kreihsl</span>.
                            </p>
                            <p class="mt-2 text-sm text-gray-400 dark:text-zinc-300">
                                &#169;Michael Hoffmann - {{new Date().getFullYear()}} - Munich, Germany 🏳️‍🌈
                            </p>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div
                v-if="deleteAccountModal"
                class="fixed z-10 inset-0 overflow-y-auto"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
            >
                <div class="flex items-end justify-center min-h-screen pt-3 px-3 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg p-3 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-500 dark:text-zinc-300" id="modal-title">
                                    Delete Account
                                </h3>

                                <div
                                    v-if="deleteMessage.type && deleteMessage.text"
                                    class="rounded-md p-3 my-3"
                                    :class="{ 'bg-green-50': deleteMessage.type === 'success', 'bg-red-50': deleteMessage.type === 'error' }"
                                >
                                    <div class="flex">
                                        <template v-if="deleteMessage.type === 'error'">
                                            <div class="flex-shrink-0">
                                                <!-- Heroicon name: solid/x-circle -->
                                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-red-800">
                                                    {{ deleteMessage.text }}
                                                </p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-zinc-300">
                                        Are you sure you want to delete your account? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex">
                            <button
                                class="button button-danger mr-3"
                                @click="deleteAccount"
                            >
                                Delete Account
                            </button>
                            <button
                                class="button button-secondary"
                                @click="toggleDeleteAccount"
                            >
                                Cancel
                            </button>
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
        const deleteAccountModal = ref(false)

        const message = ref({
            type: null,
            text: null,
        })
        const deleteMessage = ref({
            type: null,
            text: null,
        })
        const theme = ref(localStorage.theme)

        return {
            message: message,
            browserNotifications: browserNotifications,
            settings: computed(() => store.getters.settings),
            theme: theme,
            deleteMessage: deleteMessage,
            deleteAccountModal: deleteAccountModal,
        }
    },
    created() {
        const onEscape = (e) => {
            if (this.deleteAccountModal && e.keyCode === 27) {
                this.toggleDeleteAccount()
            }
        }
        document.addEventListener('keydown', onEscape)
    },
    mounted() {
        this.setupNotifications()
    },
    methods: {
        setupNotifications() {
            if (Notification.permission !== 'denied') {
                Notification.requestPermission((permission) => {
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
        toggleDeleteAccount() {
            this.deleteAccountModal = !this.deleteAccountModal
        },
        setLightTheme() {
            localStorage.theme = 'light'
            this.theme = 'light'
            document.documentElement.classList.remove('dark')
        },
        setDarkTheme() {
            localStorage.theme = 'dark'
            this.theme = 'dark'
            document.documentElement.classList.add('dark')
        },
        async saveSettings() {
            try {
                await this.$store.dispatch('saveSettings')
                this.message = {
                    type: 'success',
                    text: 'Your settings have been saved',
                }
            } catch (error) {
                this.message = {
                    type: 'error',
                    text: 'Your settings could not be saved',
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
        async deleteAccount() {
            try {
                await this.$store.dispatch('deleteAccount')
                window.location.href = '/'
            } catch (error) {
                this.deleteMessage = {
                    type: 'error',
                    text: 'Your account could not be deleted',
                }
            } finally {
                setTimeout(() => {
                    this.deleteMessage = {
                        type: null,
                        text: null,
                    }
                }, 3000)
            }
        },
    },
}
</script>
