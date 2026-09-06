<script>
export default {
    name: 'Nav',
    props: ['items'],
}
</script>

<template>
    <nav class="nav">
        <router-link
            v-for="item in items"
            :key="item.href"
            :to="item.href"
            class="nav__link"
        >
            {{ item.label }}
        </router-link>
    </nav>
</template>

<style src="./nav.css"></style>
