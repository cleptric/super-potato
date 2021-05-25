import { createStore } from 'vuex'
import { api } from '@/api'

export const store = createStore({
    state () {
        return {
            oisOasch: false,
            user: null,
            websocket: false,
            airports: {
                loww: null,
                lowi: null,
            },
        }
    },
    getters: {
        oisOasch: state => state.oisOasch,
        user: state => state.user,
        websocket: state => state.websocket,
        airports: state => state.airports,
        loww: state => state.airports.loww,
        lowi: state => state.airports.lowi,
    },
    actions: {
        async loadData({ commit }) {
            try {
                const response = await api.get('data');
                commit('SET_DATA', response.data);
            } catch (error) {
                commit('SET_OIS_OASCH');
            }
        },
        setWebsockt({ commit }, connected) {
            commit('SET_WEBSOCKET', connected);
        }
    },
    mutations: {
        SET_DATA(state, data) {
            state.airports.loww = data.loww
            state.airports.lowi = data.lowi
            state.user = data.user
        },
        SET_OIS_OASCH(state) {
            state.oisOasch = true
        },
        SET_WEBSOCKET(state, connected) {
            state.websocket = connected
        },
    },
})