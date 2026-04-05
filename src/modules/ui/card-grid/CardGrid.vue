<script>
export default {
  name: 'CardGrid',
  props: ['items'],
}
</script>

<template>
  <div class="card-grid">
    <article v-for="(item, i) in items" :key="i" class="card">
      <div class="card__media" :style="item.bg ? { background: item.bg } : null"></div>
      <div class="card__body">
        <h3 class="card__title">{{ item.title }}</h3>
      </div>
    </article>
  </div>
</template>

<style src="./card-grid.css"></style>
