<script>
import { contentStore } from '@/composables/useContent.js'

export default {
    name: 'App',
    mounted() {
        contentStore.loadAll()
    },
}
</script>

<template>
    <router-view />
</template>

<style src="./app.css"></style>
