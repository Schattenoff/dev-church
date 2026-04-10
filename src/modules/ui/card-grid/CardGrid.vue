<script>
export default {
    name: 'CardGrid',
    props: ['items'],
    methods: {
        mediaStyle(item) {
            if (item.image) return { backgroundImage: `url(${item.image})` }
            if (item.bg) return { background: item.bg }
            return null
        },
    },
}
</script>

<template>
    <div class="card-grid">
        <article v-for="(item, i) in items" :key="item.id || i" class="card">
            <div class="card__media" :style="mediaStyle(item)"></div>
            <div class="card__body">
                <h3 class="card__title">{{ item.title }}</h3>
                <p v-if="item.date" class="card__meta">{{ item.date }}</p>
                <p v-if="item.schedule" class="card__meta">{{ item.schedule }}</p>
                <p v-if="item.description" class="card__desc">{{ item.description }}</p>
            </div>
        </article>
    </div>
</template>

<style src="./card-grid.css"></style>
