<script>
import Home from '@/pages/Home.vue'
import Stub from '@/modules/stub/Stub.vue'

export default {
  name: 'App',
  components: { Home, Stub },
  data() {
    return {
      isDev: import.meta.env.DEV,
    }
  },
}
</script>

<template>
  <Stub v-if="!isDev" />
  <Home v-else />
</template>

<style src="./app.css"></style>
