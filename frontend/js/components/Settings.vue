<template>
    <div class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6">
                <div>
                    <div class="pt-6 divide-y divide-gray-200">
                        <div class="px-4 sm:px-6">
                            <div>
                                <h2 class="text-lg leading-6 font-medium text-gray-900">
                                    Settings
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Customize your super-potato experience
                                </p>
                            </div>
                            <ul class="mt-2 divide-y divide-gray-200">
                                <li class="py-4 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-1-label">
                                            Alert volume (NM)
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-1-description">
                                            Change the volume of alerts.
                                        </p>
                                    </div>
                                </li>
                                <li class="py-4 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-2-label">
                                            Request your data
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-2-description">
                                            Get a .txt file of all your personal data<br>
                                            we have stored on super-potato.
                                        </p>
                                    </div>
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-md shadow-sm text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Request your data
                                    </button>
                                </li>
                                <li class="py-4 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-2-label">
                                            Delete your account
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-2-description">
                                            Delete all your personal data forever.
                                        </p>
                                    </div>
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Delete account
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { computed } from 'vue'
    import { useStore } from 'vuex'

    export default {
        name: 'Settings',
        setup () {
            const store = useStore()
        },
    }
</script>