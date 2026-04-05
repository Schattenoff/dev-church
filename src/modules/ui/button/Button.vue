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
    <a v-if="href" :href="href" class="btn" :class="`btn--${variant}`">
        {{ label }}
    </a>
    <button v-else class="btn" :class="`btn--${variant}`" @click="onClick">
        {{ label }}
    </button>
</template>

<style src="./button.css"></style>
