<script>
export default {
    name: 'Input',
    props: ['label', 'modelValue', 'type', 'placeholder'],
    emits: ['update:modelValue'],
    methods: {
        onInput(e) {
            this.$emit('update:modelValue', e.target.value)
        },
    },
}
</script>

<template>
    <label class="field">
        <span v-if="label" class="field__label">{{ label }}</span>
        <input
            class="field__input"
            :type="type || 'text'"
            :value="modelValue"
            :placeholder="placeholder"
            @input="onInput"
        />
    </label>
</template>

<style src="./input.css"></style>
