<template>
    <template v-if="oisOasch === false">
        <Menu />
        <Settings />
        <router-view></router-view>
    </template>
    <template v-else>
        <OisOasch />
    </template>
</template>

<script>
import { useStore } from 'vuex'
import Menu from './components/Menu.vue'
import Settings from './components/Settings.vue'
import OisOasch from './components/OisOasch.vue'

export default {
    components: {
        Menu,
        Settings,
        OisOasch,
    },
    setup () {
        const store = useStore()

        return {
            setWebsockt: (connected) => store.dispatch('setWebsockt', connected),
            oisOasch: store.getters.oisOasch,
        }
    },
    mounted() {
        this.setupWebsocket();
    },
    methods: {
        setupWebsocket() {
            let socket = new WebSocket(window.jsData.wssUrl)
            const store = useStore()

            socket.addEventListener('open', () => {
                this.setWebsockt(true);
            });
            socket.addEventListener('close', () => {
                this.setWebsockt(false);
                setTimeout(() => {
                    this.setupWebsocket()
                }, 2500)
            });
            socket.addEventListener('error', () => {
                this.setWebsockt(false);
            });
            socket.addEventListener('message', (e) => {
                let data = JSON.parse(e.data)

                if (data.type == 'refresh') {
                    store.dispatch('loadData')
                }
                if (data.type == 'missed-approach') {
                    const audio = new Audio('/sounds/bell.wav')
                    // audio.volume = 0.2;
                    audio.play()
                }
                if (data.type == 'runway-closed') {
                    const audio = new Audio('/sounds/alert.wav')
                    // audio.volume = 0.2;
                    audio.play()
                }
                if (data.type == 'runway-reopened') {
                    const audio = new Audio('/sounds/success.wav')
                    // audio.volume = 0.2;
                    audio.play()
                }
            });
        },
    }
}
</script>
