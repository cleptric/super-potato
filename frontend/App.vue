<template>
    <template v-if="oisOasch">
        <OisOasch />
    </template>
    <template v-else>
        <Menu />
        <Onboarding v-if="!user.onboarded" />

        <router-view></router-view>
    </template>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import Menu from './components/Menu.vue'
import OisOasch from './components/OisOasch.vue'
import Onboarding from './components/Onboarding.vue'

export default {
    components: {
        Menu,
        OisOasch,
        Onboarding,
    },
    setup () {
        const store = useStore()

        return {
            setWebsockt: (connected) => store.dispatch('setWebsockt', connected),
            settings: computed(() => store.getters.settings),
            notifications: computed(() => store.getters.notifications),
            oisOasch: computed(() => store.getters.oisOasch),
            user: computed(() => store.getters.user),
        }
    },
    mounted() {
        this.setupWebsocket()
        this.setupAudio()
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
                    this.triggerSound('/sounds/bell.wav', data.icao)
                    this.triggerNotification(`${data.icao.toUpperCase()} Missed Apporach`, data.icao)
                }
                if (data.type == 'runway-closed') {
                    this.triggerSound('/sounds/alert.wav', data.icao)
                    this.triggerNotification(`${data.icao.toUpperCase()} Runway Closed`, data.icao)
                }
                if (data.type == 'runway-reopened') {
                    this.triggerSound('/sounds/success.wav', data.icao)
                }
            })
        },
        setupNotifications() {
            if (Notification.permission !== 'denied') {
                Notification.requestPermission()
            }
        },
        setupAudio() {
            const audio = new Audio('/sounds/silent.wav')
            let play = audio.play()
            play.then(() => {
                // sound played
            }).catch((error) => {
                // catch error
            })
        },
        triggerNotification(message, icao) {
            if (this.settings.notifications && this.notifications[icao]) {
                new Notification(message)
            }
        },
        triggerSound(sound, icao) {
            if (this.settings.sounds && this.notifications[icao]) {
                const audio = new Audio(sound)
                audio.volume = this.settings.volume

                let play = audio.play()
                play.then(() => {
                    // sound played
                }).catch((error) => {
                    // catch error
                })
            }
        }
    }
}
</script>
