<script>
import { api } from '@/config/fetch.js'
import Input from '@/modules/ui/input/Input.vue'
import Textarea from '@/modules/ui/textarea/Textarea.vue'
import ImageUpload from '@/modules/ui/image-upload/ImageUpload.vue'
import Button from '@/modules/ui/button/Button.vue'
import Modal from '@/modules/ui/modal/Modal.vue'

function empty() {
    return { title: '', description: '', date: '', image: '' }
}

export default {
    name: 'NewsAdmin',
    components: { Input, Textarea, ImageUpload, Button, Modal },
    data() {
        return {
            news: [],
            isReady: false,
            editingId: null,
            form: empty(),
            showForm: false,
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {
            this.news.length > 0 && (this.news.length = 0)
            api.fetch('/news/get', null, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                this.news = res.news
                this.isReady = true
            })
        },
        startCreate() {
            this.editingId = null
            this.form = empty()
            this.showForm = true
        },
        startEdit(item) {
            this.editingId = item.id
            this.form = {
                title: item.title,
                description: item.description,
                date: item.date,
                image: item.image,
            }
            this.showForm = true
        },
        cancel() {
            this.showForm = false
            this.editingId = null
            this.form = empty()
        },
        onSave() {
            if (!this.form.title.trim()) return

            const payload = {
                data: {
                    title: this.form.title,
                    description: this.form.description,
                    date: this.form.date,
                    image: this.form.image,
                },
            }
            if (this.editingId) payload.data.id = this.editingId

            api.fetch('/news/save', payload, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                api.growl('Сохранено', 'success')
                this.cancel()
                this.getData()
            })
        },
        onDelete(item) {
            if (!window.confirm(`Удалить новость «${item.title}»?`)) return
            api.fetch('/news/delete', { data: { id: item.id } }, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                api.growl('Удалено', 'success')
                this.getData()
            })
        },
    },
}
</script>

<template>
    <div>
        <div class="admin__header">
            <h1 class="admin__title">Новости</h1>
            <Button label="+ Добавить" variant="filled" @click="startCreate" />
        </div>

        <Modal
            :open="showForm"
            :title="editingId ? 'Редактировать новость' : 'Новая новость'"
            @close="cancel"
        >
            <form class="admin__form" @submit.prevent="onSave">
                <Input label="Заголовок" v-model="form.title" placeholder="Название новости" />
                <Input label="Дата" v-model="form.date" placeholder="Например: 24 декабря 2026" />
                <Textarea label="Описание" v-model="form.description" placeholder="Короткое описание" />
                <ImageUpload label="Фото" v-model="form.image" />
                <div class="admin__formActions">
                    <Button :label="editingId ? 'Сохранить' : 'Добавить'" variant="filled" />
                    <Button label="Отмена" variant="outlined" @click="cancel" />
                </div>
            </form>
        </Modal>

        <div v-if="news.length" class="admin__list">
            <article v-for="item in news" :key="item.id" class="adminItem">
                <div class="adminItem__media">
                    <img v-if="item.image" :src="item.image" alt="" />
                    <div v-else class="adminItem__mediaEmpty">Без фото</div>
                </div>
                <div class="adminItem__body">
                    <h3 class="adminItem__title">{{ item.title }}</h3>
                    <p v-if="item.date" class="adminItem__meta">{{ item.date }}</p>
                    <p v-if="item.description" class="adminItem__desc">{{ item.description }}</p>
                </div>
                <div class="adminItem__actions">
                    <button class="adminItem__btn" @click="startEdit(item)">Редактировать</button>
                    <button class="adminItem__btn adminItem__btn--danger" @click="onDelete(item)">Удалить</button>
                </div>
            </article>
        </div>
        <p v-else-if="isReady" class="admin__hint">Пока нет новостей.</p>
    </div>
</template>

<style src="./admin.css"></style>
