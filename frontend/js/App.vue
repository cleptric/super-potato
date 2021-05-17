<template>
    <Menu />
    <router-view></router-view>
</template>

<script>
import { useStore } from 'vuex'
import Menu from './components/Menu.vue'

export default {
    components: {
        Menu,
    },
    data() {
        return {
            connected: null,
        }
    },
    mounted() {
        this.setupWebsocket();
    },
    methods: {
        setupWebsocket() {
            const socket = new WebSocket(window.jsData.wssUrl)
            const store = useStore()

            socket.addEventListener('open', () => {
                this.connected = true
            });
            socket.addEventListener('close', () => {
                this.connected = false
            });
            socket.addEventListener('error', () => {
                this.connected = false
                // retry
            });
            socket.addEventListener('message', (e) => {
                let data = JSON.parse(e.data)

                if (data.type == 'refresh') {
                    store.dispatch('loadData')
                }
                if (data.type == 'missed-approach') {
                    const audio = new Audio('/sounds/bell.wav')
                    audio.play()

                    store.dispatch('loadData')
                }
                if (data.type == 'runway-closed') {
                    const audio = new Audio('/sounds/alert.wav')
                    audio.play()
                }
                if (data.type == 'runway-reopened') {
                    const audio = new Audio('/sounds/success.wav')
                    audio.play()
                }
            });
        },
    }
}
</script>
