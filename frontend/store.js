import { createStore } from 'vuex'
import { api } from '@/api'

export const store = createStore({
    state () {
        return {
            user: null,
            logs: null,
            debug: false,
            websocket: false,
            airports: {
                loww: null,
            },
            settings: {
                notifications: true,
                sounds: true,
                volume: 0.5,
            },
            notifications: {
                loww: true,
            },
            adminData: {
                users: null,
            },
        }
    },
    getters: {
        user: state => state.user,
        logs: state => state.logs,
        debug: state => state.debug,
        websocket: state => state.websocket,
        airports: state => state.airports,
        settings: state => state.settings,
        notifications: state => state.notifications,
        loww: state => state.airports.loww,
        adminData: state => state.adminData,
    },
    actions: {
        async loadData({ commit }) {
            try {
                const response = await api.get('data/get-data')
                commit('SET_DATA', response.data)
            } catch (error) {
            }
        },
        async loadAdminData({ commit }) {
            try {
                const response = await api.get('admin/get-data')
                commit('SET_ADMIN_DATA', response.data)
            } catch (error) {
            }
        },
        async loadSettings({ commit, state }) {
            try {
                const response = await api.get('data/get-settings')
                commit('SET_SETTINGS', response.data)
            } catch (error) {
            }
        },
        async saveSettings({ commit, state }) {
            try {
                await api.post('data/save-settings', {
                    settings: state.settings,
                })
            } catch (error) {
                throw error
            }
        },
        async deleteAccount({ commit }) {
            try {
                await api.delete('users/delete-account')
            } catch (error) {
                throw error
            }
        },
        async loadNotifications({ commit, state }) {
            try {
                const response = await api.get('data/get-notifications')
                commit('SET_NOTIFICATIONS', response.data)
            } catch (error) {
            }
        },
        async saveNotifications({ commit, state }) {
            try {
                await api.post('data/save-notifications', {
                    notifications: state.notifications,
                })
            } catch (error) {
                throw error
            }
        },
        async blockUser({ dispatch }, data) {
            try {
                await api.post('admin/block-user', {
                    user_id: data.user_id
                })
                dispatch('loadAdminData')
            } catch (error) {
                throw error
            }
        },
        async unblockUser({ dispatch }, data) {
            try {
                await api.post('admin/unblock-user', {
                    user_id: data.user_id
                })
                dispatch('loadAdminData')
            } catch (error) {
                throw error
            }
        },
        toggleNotification({ commit }, icao) {
            commit('TOGGLE_NOTIFICATION', icao)
        },
        setWebsockt({ commit }, connected) {
            commit('SET_WEBSOCKET', connected)
        },
        setUser({ commit }, data) {
            commit('SET_USER', data)
        },
    },
    mutations: {
        SET_DATA(state, data) {
            state.airports.loww = data.loww
            state.user = data.user
            state.logs = data.logs
            state.debug = data.debug
        },
        SET_ADMIN_DATA(state, data) {
            state.adminData = data
        },
        SET_SETTINGS(state, data) {
            state.settings = data.settings
        },
        SET_NOTIFICATIONS(state, data) {
            state.notifications = data.notifications
        },
        TOGGLE_NOTIFICATION(state, icao) {
            state.notifications[icao] = !state.notifications[icao]
        },
        SET_WEBSOCKET(state, connected) {
            state.websocket = connected
        },
        SET_USER(state, data) {
            state.user = {
                ...state.user,
                ...data,
            }
        },
    },
})