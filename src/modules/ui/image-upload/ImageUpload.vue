<script>
import { api } from '@/config/api.js'

const MAX_BYTES = 5 * 1024 * 1024 // 5MB — синхронизировано с api/config.example.php

export default {
    name: 'ImageUpload',
    props: ['label', 'modelValue'],
    emits: ['update:modelValue'],
    data() {
        return { error: '', uploading: false }
    },
    methods: {
        async onFile(e) {
            this.error = ''
            const file = e.target.files && e.target.files[0]
            if (!file) return
            if (!file.type.startsWith('image/')) {
                this.error = 'Файл должен быть изображением'
                return
            }
            if (file.size > MAX_BYTES) {
                this.error = 'Файл больше 5 МБ — выберите меньше'
                e.target.value = ''
                return
            }
            this.uploading = true
            try {
                const res = await api.upload('/upload', file)
                this.$emit('update:modelValue', res.url)
            } catch (err) {
                this.error = err.message || 'Не удалось загрузить файл'
            } finally {
                this.uploading = false
                if (this.$refs.input) this.$refs.input.value = ''
            }
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
            <input ref="input" type="file" accept="image/*" :disabled="uploading" @change="onFile" />
            <span v-if="uploading">Загрузка…</span>
            <span v-else>Выбрать фото (до 5 МБ)</span>
        </label>
        <p v-if="error" class="image-upload__error">{{ error }}</p>
    </div>
</template>

<style src="./image-upload.css"></style>
