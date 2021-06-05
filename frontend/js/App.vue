<template>
    <template v-if="oisOasch">
        <OisOasch />
    </template>
    <template v-else>
        <Menu />
        <Settings />
        <router-view></router-view>
    </template>
    <Onboarding
        v-if="!user.onboarded"
    />
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import Menu from './components/Menu.vue'
import Settings from './components/Settings.vue'
import OisOasch from './components/OisOasch.vue'
import Onboarding from './components/Onboarding.vue'

export default {
    components: {
        Menu,
        Settings,
        OisOasch,
        Onboarding,
    },
    setup () {
        const store = useStore()

        return {
            setWebsockt: (connected) => store.dispatch('setWebsockt', connected),
            settings: computed(() => store.getters.settings),
            oisOasch: computed(() => store.getters.oisOasch),
            user: computed(() => store.getters.user),
        }
    },
    mounted() {
        this.setupWebsocket()
        this.setupNotifications()
    },
    methods: {
        setupWebsocket() {
            let socket = new WebSocket(window.jsData.wssUrl)
            const store = useStore()

            socket.addEventListener('open', () => {
                this.setWebsockt(true)
            })
            socket.addEventListener('close', () => {
                this.setWebsockt(false)
                setTimeout(() => {
                    this.setupWebsocket()
                }, 2500)
            })
            socket.addEventListener('error', () => {
                this.setWebsockt(false)
            })
            socket.addEventListener('message', (e) => {
                let data = JSON.parse(e.data)

                if (data.type == 'refresh') {
                    store.dispatch('loadData')
                }
                if (data.type == 'missed-approach') {
                    this.triggerSound('/sounds/bell.wav')
                    this.triggerNotification(`${data.airport} Missed Apporach`)
                }
                if (data.type == 'runway-closed') {
                    this.triggerSound('/sounds/alert.wav')
                    this.triggerNotification(`${data.airport} Runway Closed`)
                }
                if (data.type == 'runway-reopened') {
                    this.triggerSound('/sounds/success.wav')
                }
            })
        },
        setupNotifications() {
            if (Notification.permission !== 'denied') {
                Notification.requestPermission()
            }
        },
        triggerNotification(message) {
            if (this.settings.notifications) {
                new Notification(message)
            }
        },
        triggerSound(sound) {
            if (this.settings.sounds) {
                const audio = new Audio(sound)
                audio.volume = this.settings.volume
                audio.play()
            }
        }
    }
}
</script>
