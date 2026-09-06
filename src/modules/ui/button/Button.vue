<script>
export default {

    name: 'Button',

    props: ['label', 'href', 'variant'],

    methods: {
        onClick() {
            this.$emit('click');
        }
    }

}
</script>

<template>
    <router-link v-if="href && href.startsWith('/')" :to="href" class="btn" :class="`btn--${variant}`">
        {{ label }}
    </router-link>
    <a v-else-if="href" :href="href" class="btn" :class="`btn--${variant}`">
        {{ label }}
    </a>
    <button v-else class="btn" :class="`btn--${variant}`" @click="onClick">
        {{ label }}
    </button>
</template>

<style src="./button.css"></style>
