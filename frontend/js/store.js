import { createStore } from 'vuex'
import { api } from '@/api'

export const store = createStore({
    state () {
        return {
            user: null,
            websocket: false,
            airports: {
                loww: null,
            },
        }
    },
    getters: {
        user: state => state.user,
        websocket: state => state.websocket,
        airports: state => state.airports,
        loww: state => state.airports.loww,
        lows: state => state.airports.lows,
    },
    actions: {
        async loadData({ commit }) {
            const response = await api.get('data');
            commit('SET_DATA', response.data);
        },
        setWebsockt({ commit }, connected) {
            commit('SET_WEBSOCKET', connected);
        }
    },
    mutations: {
        SET_DATA(state, data) {
            state.airports.loww = data.loww
            state.user = data.user
        },
        SET_WEBSOCKET(state, connected) {
            state.websocket = connected
        },
    },
})