import { createStore } from 'vuex'
import { api } from '@/api'

export const store = createStore({
    state () {
        return {
            airports: {
                loww: null,
                lows: null,
            },
        }
    },
    getters: {
        airports: state => state.airports,
        loww: state => state.airports.loww,
        lows: state => state.airports.lows,
    },
    actions: {
        async loadData({ commit, getters }) {
            const response = await api.get('data');
            commit('SET_DATA', response.data);
        },
    },
    mutations: {
        SET_DATA(state, data) {
            state.airports = data
        },
    },
})