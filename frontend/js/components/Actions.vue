<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Visual Depatures
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                        <button 
                            @click="triggerVisualDepature('north')"
                            class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-blue-300 bg-blue-200 text-blue-700 hover:bg-blue-100': loww.visual_depature.includes('north') }"
                        >
                            North
                        </button>
                        <button 
                            @click="triggerVisualDepature('east')"
                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-blue-300 bg-blue-200 text-blue-700 hover:bg-blue-100': loww.visual_depature.includes('east') }"
                        >
                            East
                        </button>
                        <button
                            @click="triggerVisualDepature('south')"
                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-blue-300 bg-blue-200 text-blue-700 hover:bg-blue-100': loww.visual_depature.includes('south') }"
                        >
                            South
                        </button>
                        <button
                            @click="triggerVisualDepature('west')"
                            class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-blue-300 bg-blue-200 text-blue-700 hover:bg-blue-100': loww.visual_depature.includes('west') }"
                        >
                            West
                        </button>
                    </span>
                </dd>
            </div>

            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Runway Closed
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                        <button
                            @click="triggerRunwayClosed('16/34')"
                            class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-300 bg-red-200 text-red-800 hover:bg-red-100 focus:ring-red-500 focus:border-red-500': loww.closed_runways.includes('16/34') }"
                        >
                            <i v-if="loww.closed_runways.includes('16/34')" class="far fa-times mr-1 text-red-800"></i> 16 / 34
                        </button>
                        <button 
                            @click="triggerRunwayClosed('29/11')"
                            class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-300 bg-red-200 text-red-800 hover:bg-red-100 focus:ring-red-500 focus:border-red-500': loww.closed_runways.includes('29/11') }"
                        >
                            <i v-if="loww.closed_runways.includes('29/11')" class="far fa-times mr-1 text-red-800"></i> 29 / 11
                        </button>
                    </span>
                </dd>
            </div>

            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Missed Approach
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <button
                        v-if="loww.missed_approach"
                        @click="triggerMissedApproach"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="far fa-times mr-2"></i>
                        Remove Notification
                    </button>
                    <button
                        v-else
                        @click="triggerMissedApproach"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="far fa-bells mr-2"></i> Trigger Notification
                    </button>
                </dd>
            </div>

        </dl>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { api } from '@/api'

export default {
    name: 'Actions',
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
        }
    },
    methods: {
        triggerMissedApproach() {
            if (this.loww.missed_approach) {
                api.post('data/cancel-missed-approach')
            } else {
                api.post('data/missed-approach')
            }
        },
        triggerRunwayClosed(runways) {
            api.post('data/update-runway-closed', {
                runways: runways,
            })
        },
        triggerVisualDepature(direction) {
            api.post('data/update-visual-depature', {
                direction: direction,
            })
        },
    }
}
</script>