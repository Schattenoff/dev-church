<script>
export default {
  name: 'Nav',
  props: ['items'],
}
</script>

<template>
  <nav class="nav">
    <a
      v-for="item in items"
      :key="item.href"
      :href="item.href"
      class="nav__link"
    >
      {{ item.label }}
    </a>
  </nav>
</template>

<style src="./nav.css"></style>
