<template>
    <Menu />
    <router-view></router-view>
</template>

<script>
import { computed, ref } from 'vue'
import { useStore } from 'vuex'

import Menu from '@/components/Admin/Menu.vue'

export default {
    name: 'Admin',
    components: {
        Menu,
    },
    setup () {
        const store = useStore()

        return {
            adminData: computed(() => store.getters.adminData),
        }
    },
    created() {
        this.$store.dispatch('loadAdminData')
    },
}
</script>