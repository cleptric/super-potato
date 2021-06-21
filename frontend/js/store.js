import { createStore } from 'vuex'
import { api } from '@/api'

export const store = createStore({
    state () {
        return {
            oisOasch: false,
            user: null,
            logs: null,
            websocket: false,
            airports: {
                loww: null,
                lowi: null,
                lows: null,
                lowg: null,
                lowk: null,
                lowl: null,
            },
            settings: {
                notifications: true,
                sounds: true,
                volume: 0.5,
            },
            notifications: {
                loww: true,
                lowi: true,
                lows: true,
                lowg: true,
                lowk: true,
                lowl: true,
            },
        }
    },
    getters: {
        oisOasch: state => state.oisOasch,
        user: state => state.user,
        logs: state => state.logs,
        websocket: state => state.websocket,
        airports: state => state.airports,
        settings: state => state.settings,
        notifications: state => state.notifications,
        loww: state => state.airports.loww,
        lowi: state => state.airports.lowi,
        lows: state => state.airports.lows,
        lowg: state => state.airports.lowg,
        lowk: state => state.airports.lowk,
        lowl: state => state.airports.lowl,
    },
    actions: {
        async loadData({ commit }) {
            try {
                const response = await api.get('data/get-data')
                commit('SET_DATA', response.data)
            } catch (error) {
                commit('SET_OIS_OASCH')
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
            state.airports.lowi = data.lowi
            state.airports.lows = data.lows
            state.airports.lowg = data.lowg
            state.airports.lowk = data.lowk
            state.airports.lowl = data.lowl
            state.user = data.user
            state.logs = data.logs
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
        SET_OIS_OASCH(state) {
            state.oisOasch = true
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