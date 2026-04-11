<script>
import Growl from '@/modules/ui/growl/Growl.vue'

export default {
    name: 'App',
    components: { Growl },
}
</script>

<template>
    <router-view />
    <Growl />
</template>

<style src="./app.css"></style>
