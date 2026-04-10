<script>
export default {
    name: 'Textarea',
    props: ['label', 'modelValue', 'placeholder', 'rows'],
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
        <textarea
            class="field__input field__input--textarea"
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows || 4"
            @input="onInput"
        ></textarea>
    </label>
</template>

<style src="../input/input.css"></style>

<style scoped>
.field__input--textarea {
    font-family: var(--font-family);
    resize: vertical;
    min-height: 90px;
}
</style>
