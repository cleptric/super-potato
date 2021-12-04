<template>
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-900">
                Admin
            </h1>
        </div>
    </header>
    <main>

        <div
            v-if="message.type && message.text"
            class="max-w-7xl mx-auto py-7 sm:px-6 lg:px-8"
        >
            <div
                class="rounded-md p-4"
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
        </div>

        <div
            v-if="adminData.users"
            class="max-w-7xl mx-auto py-7 sm:px-6 lg:px-8"
        >
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Full Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Vatsim ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Username
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(user, index) in adminData.users"
                                        :key="index"
                                        :class="index % 2 == 0 ? 'bg-white' : 'bg-gray-100'"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ user.full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ user.vatsim_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ user.username }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <template v-if="user.admin">Admin</template>
                                            <template v-else>User</template>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <i
                                                class="fas fa-circle text-xs mr-1"
                                                :class="{ 'text-green-400': user.status === 'active', 'text-red-400': user.status === 'blocked' }"
                                            ></i>
                                            {{ user.status }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">
                                            <template v-if="user.status === 'active'">
                                                <button
                                                    class="ml-2 inline-flex items-center px-2 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                                    @click="blockUser(user.id)"
                                                >
                                                    <i class="far fa-ban text-xs mr-1"></i> Block
                                                </button>
                                            </template>
                                            <template v-else-if="user.status === 'blocked'">
                                                <button
                                                    class="ml-2 inline-flex items-center px-2 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                                    @click="unblockUser(user.id)"
                                                >
                                                    <i class="far fa-check text-xs mr-1"></i> Unblock
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
    name: 'Admin',
    setup () {
        const store = useStore()

        const message = ref({
            type: null,
            text: null,
        })

        return {
            message: message,
            adminData: computed(() => store.getters.adminData),
        }
    },
    created() {
        this.$store.dispatch('loadAdminData')
    },
    methods: {
        async blockUser(userId) {
            try {
                await this.$store.dispatch('blockUser', { user_id: userId })
            } catch (error) {
                this.message = {
                    type: 'error',
                    text: 'User could not be blocked',
                }
            } finally {
                setTimeout(() => {
                    this.message = {
                        type: null,
                        text: null,
                    }
                }, 5000)
            }
        },
        async unblockUser(userId) {
            try {
                await this.$store.dispatch('unblockUser', { user_id: userId })
            } catch (error) {
                this.message = {
                    type: 'error',
                    text: 'User could not be unblocked',
                }
            } finally {
                setTimeout(() => {
                    this.message = {
                        type: null,
                        text: null,
                    }
                }, 5000)
            }
        },
    },
}
</script>
