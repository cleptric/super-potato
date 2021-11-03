<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-screen-xl sm:w-full sm:p-6">
                <div>
                    <div class="relative bg-white py-16 sm:py-24 lg:py-32">
                        <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                            <h2 class="text-base font-semibold tracking-wider text-blue-600 uppercase">
                                's leiwand
                            </h2>
                            <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                                Welcome to Super <img class="inline-block h-7 w-7 ml-1" :src="logoUrl">
                            </p>
                            <p class="mt-5 max-w-prose mx-auto text-xl text-gray-500">
                                Looks like this is your first time using Super Potato. This a quick overview of the most important features it offers. We hope you'll enojy using them.
                            </p>
                            <div class="mt-12">
                                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                    <div class="pt-6">
                                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                            <div class="-mt-6">
                                                <div>
                                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                                        <div class="h-6 w-6 text-white">
                                                            <i class="far fa-lg fa-plane"></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Active Runways</h3>
                                                <p class="mt-5 text-base text-gray-500">
                                                    See which runways are currently used at the airports. An ATIS needs to be online.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6">
                                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                            <div class="-mt-6">
                                                <div>
                                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                                        <div class="h-6 w-6 text-white">
                                                            <i class="far fa-lg fa-wind"></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Wind Components</h3>
                                                <p class="mt-5 text-base text-gray-500">
                                                    Get the current cross, tail and head wind components for all runways on each airport.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6">
                                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                            <div class="-mt-6">
                                                <div>
                                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                                        <div class="h-6 w-6 text-white">
                                                            <i class="far fa-lg fa-bell-on"></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Notifications</h3>
                                                <p class="mt-5 text-base text-gray-500">
                                                    Let other vATC know if a missed approach was perfomed or a runway is closed. You need to be online as vATC on VATSIM.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6">
                                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                            <div class="-mt-6">
                                                <div>
                                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                                        <div class="h-6 w-6 text-white">
                                                            <i class="far fa-lg fa-sun-cloud"></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">METAR decoding</h3>
                                                <p class="mt-5 text-base text-gray-500">
                                                    Get the most important METAR information for each airport at a glance.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6">
                                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                            <div class="-mt-6">
                                                <div>
                                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                                        <div class="h-6 w-6 text-white">
                                                            <i class="far fa-lg fa-plane-departure"></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Visual Departures</h3>
                                                <p class="mt-5 text-base text-gray-500">
                                                    Let the TWR controller know if visual departures are approved. Supported at LOWW and LOWI.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6">
                                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                            <div class="-mt-6">
                                                <div>
                                                    <span class="inline-flex items-center justify-center p-3 bg-blue-500 rounded-md shadow-lg">
                                                        <div class="h-6 w-6 text-white">
                                                            <i class="far fa-lg fa-monitor-heart-rate"></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Live Data Updates</h3>
                                                <p class="mt-5 text-base text-gray-500">
                                                    You'll get any new data pushed automatically to your client. No need to refresh your browser.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="mt-12 max-w-prose mx-auto text-xl text-gray-500">
                                    Be sure to head over to the settings page to adjust the settings to your personal preferences.
                                </p>
                                <button
                                    class="mt-5 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    @click="completeOnboarding"
                                    >
                                    Start using Super Potato
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useStore } from 'vuex'
import { api } from '@/api'

export default {
    name: 'Onboarding',
    setup () {
        const store = useStore()

        return {
            logoUrl: '/img/potato.png',
            setUser: () => store.dispatch('setUser', {
                onboarded: true,
            })
        }
    },
    methods: {
        completeOnboarding() {
            this.setUser()
            api.post('data/complete-onboarding')
        }
    }
}
</script>
