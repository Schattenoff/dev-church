<script>
const MAX_BYTES = 1024 * 1024 // 1MB — base64 в localStorage раздувается, держим компактно

export default {
    name: 'ImageUpload',
    props: ['label', 'modelValue'],
    emits: ['update:modelValue'],
    data() {
        return { error: '' }
    },
    methods: {
        onFile(e) {
            this.error = ''
            const file = e.target.files && e.target.files[0]
            if (!file) return
            if (!file.type.startsWith('image/')) {
                this.error = 'Файл должен быть изображением'
                return
            }
            if (file.size > MAX_BYTES) {
                this.error = 'Файл больше 1 МБ — выберите меньше'
                e.target.value = ''
                return
            }
            const reader = new FileReader()
            reader.onload = () => this.$emit('update:modelValue', reader.result)
            reader.onerror = () => (this.error = 'Не удалось прочитать файл')
            reader.readAsDataURL(file)
        },
        clear() {
            this.$emit('update:modelValue', '')
            if (this.$refs.input) this.$refs.input.value = ''
        },
    },
}
</script>

<template>
    <div class="image-upload">
        <span v-if="label" class="image-upload__label">{{ label }}</span>
        <div v-if="modelValue" class="image-upload__preview">
            <img :src="modelValue" alt="" />
            <button type="button" class="image-upload__remove" @click="clear">Удалить фото</button>
        </div>
        <label v-else class="image-upload__dropzone">
            <input ref="input" type="file" accept="image/*" @change="onFile" />
            <span>Выбрать фото (до 1 МБ)</span>
        </label>
        <p v-if="error" class="image-upload__error">{{ error }}</p>
    </div>
</template>

<style src="./image-upload.css"></style>
