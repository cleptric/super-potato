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
                    <div
                        v-if="settingsMessage.type && settingsMessage.text"
                        class="rounded-md p-4 mb-4"
                        :class="{ 'bg-green-50': settingsMessage.type === 'success', 'bg-red-50': settingsMessage.type === 'error' }"
                    >
                        <div class="flex">
                            <template v-if="settingsMessage.type === 'success'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/check-circle -->
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ settingsMessage.text }}
                                    </p>
                                </div>
                            </template>
                            <template v-if="settingsMessage.type === 'error'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/x-circle -->
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ settingsMessage.text }}
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
                                    class="inline-flex items-center py-2 px-4 border border-transparent text-sm font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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
                    <div
                        v-if="passwordMessage.type && passwordMessage.text"
                        class="rounded-md p-4 mb-4"
                        :class="{ 'bg-green-50': passwordMessage.type === 'success', 'bg-red-50': passwordMessage.type === 'error' }"
                    >
                        <div class="flex">
                            <template v-if="passwordMessage.type === 'success'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/check-circle -->
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ passwordMessage.text }}
                                    </p>
                                </div>
                            </template>
                            <template v-if="passwordMessage.type === 'error'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/x-circle -->
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ passwordMessage.text }}
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">Change your Password</legend>
                            <p class="text-sm text-gray-500">Your new password must be at least 8 characters long</p>
                            <form
                                ref="passwordForm"
                                class="mt-4 space-y-4"
                            >
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">
                                        Current Password
                                    </label>
                                    <div class="input mt-1 text">
                                        <input
                                            ref="currentPassword"
                                            type="password"
                                            name="current_password"
                                            placeholder="········"
                                            autocomplete="current-password"
                                            class="form-input w-full max-w-md px-4 py-3 leading-4 border-gray-300 rounded-md placeholder-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            @keyup.stop
                                        >
                                    </div>
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700">
                                        New Password
                                    </label>
                                    <div class="input mt-1 text">
                                        <input
                                            ref="newPassword"
                                            type="password"
                                            name="new_password"
                                            placeholder="········"
                                            autocomplete="new-password"
                                            class="form-input w-full max-w-md px-4 py-3 leading-4 border-gray-300 rounded-md placeholder-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            @keyup.stop
                                        >
                                    </div>
                                </div>
                            </form>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center">
                                    <button 
                                        class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600"
                                        @click="changePassword"
                                    >
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div
                        v-if="deleteMessage.type && deleteMessage.text"
                        class="rounded-md p-4 mb-4"
                        :class="{ 'bg-green-50': deleteMessage.type === 'success', 'bg-red-50': deleteMessage.type === 'error' }"
                    >
                        <div class="flex">
                            <template v-if="deleteMessage.type === 'success'">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/check-circle -->
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ deleteMessage.text }}
                                    </p>
                                </div>
                            </template>
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

                    <div class="space-y-2">
                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">Delete Account</legend>
                            <p class="text-sm text-gray-500">If you do not want to continue using Super Potato, you can delete your account</p>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center">
                                    <button 
                                        class="inline-flex items-center py-2 px-4 border border-transparent text-sm font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="space-y-2">
                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">Onboarding</legend>
                            <p class="text-sm text-gray-500">See the onboarding message again</p>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center">
                                    <button 
                                        class="inline-flex items-center py-2 px-4 border border-transparent text-sm font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        @click="showOnboarding"
                                    >
                                      Show Onboarding
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="space-y-2">
                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">About</legend>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    Super Potato was build with <a href="https://cakephp.org/" target="_blank" rel="noopener" class="underline">CakePHP</a>, <a href="https://vuejs.org/" target="_blank" rel="noopener" class="underline">Vue.js</a> and <a href="https://tailwindcss.com/" target="_blank" rel="noopener" class="underline">Tailwind CSS</a> and many other tools.
                                </p>
                                <p class="text-sm text-gray-500">
                                    The source code is available on <a href="https://github.com/cleptric/super-potato" target="_blank" rel="noopener" class="underline">GitHub</a> and is published under the MIT license.
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
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div
        v-if="deleteAccountModal"
        class="fixed z-10 inset-0 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: outline/exclamation -->
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Account
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete your account? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:ml-10 sm:pl-4 sm:flex">
                            <button
                                class="inline-flex items-center py-2 px-4 border border-transparent text-sm font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                @click="deleteAccount"
                            >
                                Delete Account
                            </button>
                            <button
                                class="ml-3 inline-flex items-center py-2 px-4 border border-transparent text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                @click="toggleDeleteAccount"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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

        const settingsMessage = ref({
            type: null,
            text: null,
        })
        const passwordMessage = ref({
            type: null,
            text: null,
        })
        const deleteMessage = ref({
            type: null,
            text: null,
        })

        return {
            settingsMessage: settingsMessage,
            passwordMessage: passwordMessage,
            deleteMessage: deleteMessage,
            browserNotifications: browserNotifications,
            deleteAccountModal: deleteAccountModal,
            settings: computed(() => store.getters.settings),
        }
    },
    watch: {
        deleteAccountModal: {
            immediate: true,
            handler(deleteAccountModal) {
                if (deleteAccountModal) {
                    document.body.style.setProperty('overflow', 'hidden');
                } else {
                    document.body.style.removeProperty('overflow');
                }
            },
        },
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
        showOnboarding() {
            this.$store.dispatch('setUser', {
                onboarded: false,
            })
        },
        toggleDeleteAccount() {
            this.deleteAccountModal = !this.deleteAccountModal
        },
        async saveSettings() {
            try {
                await this.$store.dispatch('saveSettings')
                this.settingsMessage = {
                    type: 'success',
                    text: 'Your settings have been saved',
                }
            } catch (error) {
                this.settingsMessage = {
                    type: 'error',
                    text: 'Your settings could not be saved',
                }
            } finally {
                setTimeout(() => {
                    this.settingsMessage = {
                        type: null,
                        text: null,
                    }
                }, 5000)
            }
        },
        async changePassword() {
            try {
                let data = new FormData(this.$refs.passwordForm)

                await this.$store.dispatch('changePassword', data)
                this.passwordMessage = {
                    type: 'success',
                    text: 'Your password has been changed',
                }
                this.$refs.currentPassword.value = null
                this.$refs.newPassword.value = null
            } catch (error) {
                this.passwordMessage = {
                    type: 'error',
                    text: 'Your password could not be changed',
                }
            } finally {
                setTimeout(() => {
                    this.passwordMessage = {
                        type: null,
                        text: null,
                    }
                }, 5000)
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
                }, 5000)
            }
        },
    },
}
</script>
