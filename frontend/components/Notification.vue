<template>
    <svg
        v-if="airport.notification"
        class="absolute -top-1.5 -left-1.5 h-4 w-4 text-red-400"
        fill="currentColor"
        viewBox="0 0 8 8"
    >
        <circle cx="4" cy="4" r="3" />
    </svg>
</template>

<script>
export default {
    name: 'Notification',
    props: {
        airport: Object
    },
}
</script>