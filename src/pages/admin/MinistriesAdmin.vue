<script>
import { contentStore } from '@/composables/useContent.js'
import Input from '@/modules/ui/input/Input.vue'
import Textarea from '@/modules/ui/textarea/Textarea.vue'
import ImageUpload from '@/modules/ui/image-upload/ImageUpload.vue'
import Button from '@/modules/ui/button/Button.vue'
import Modal from '@/modules/ui/modal/Modal.vue'

function empty() {
    return { title: '', description: '', schedule: '', leader: '', image: '' }
}

export default {
    name: 'MinistriesAdmin',
    components: { Input, Textarea, ImageUpload, Button, Modal },
    data() {
        return {
            editingId: null,
            form: empty(),
            showForm: false,
        }
    },
    computed: {
        ministries() { return contentStore.ministries },
    },
    methods: {
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
                schedule: item.schedule,
                leader: item.leader,
                image: item.image,
            }
            this.showForm = true
        },
        cancel() {
            this.showForm = false
            this.editingId = null
            this.form = empty()
        },
        save() {
            if (!this.form.title.trim()) return
            if (this.editingId) {
                contentStore.updateMinistry(this.editingId, { ...this.form })
            } else {
                contentStore.addMinistry({ ...this.form })
            }
            this.cancel()
        },
        confirmRemove(item) {
            if (window.confirm(`Удалить служение «${item.title}»?`)) {
                contentStore.removeMinistry(item.id)
            }
        },
    },
}
</script>

<template>
    <div>
        <div class="admin__header">
            <h1 class="admin__title">Служения</h1>
            <Button label="+ Добавить" variant="filled" @click="startCreate" />
        </div>

        <Modal
            :open="showForm"
            :title="editingId ? 'Редактировать служение' : 'Новое служение'"
            @close="cancel"
        >
            <form class="admin__form" @submit.prevent="save">
                <Input label="Название" v-model="form.title" placeholder="Например: Молодёжное служение" />
                <Textarea label="Описание" v-model="form.description" placeholder="О чём это служение" />
                <Input label="Расписание" v-model="form.schedule" placeholder="Например: пятница, 19:00" />
                <Input label="Ответственный" v-model="form.leader" placeholder="Имя лидера" />
                <ImageUpload label="Фото" v-model="form.image" />
                <div class="admin__formActions">
                    <Button :label="editingId ? 'Сохранить' : 'Добавить'" variant="filled" />
                    <Button label="Отмена" variant="outlined" @click="cancel" />
                </div>
            </form>
        </Modal>

        <div v-if="ministries.length" class="admin__list">
            <article v-for="item in ministries" :key="item.id" class="adminItem">
                <div class="adminItem__media">
                    <img v-if="item.image" :src="item.image" alt="" />
                    <div v-else class="adminItem__mediaEmpty">Без фото</div>
                </div>
                <div class="adminItem__body">
                    <h3 class="adminItem__title">{{ item.title }}</h3>
                    <p v-if="item.schedule" class="adminItem__meta">{{ item.schedule }}</p>
                    <p v-if="item.leader" class="adminItem__meta">Ответственный: {{ item.leader }}</p>
                    <p v-if="item.description" class="adminItem__desc">{{ item.description }}</p>
                </div>
                <div class="adminItem__actions">
                    <button class="adminItem__btn" @click="startEdit(item)">Редактировать</button>
                    <button class="adminItem__btn adminItem__btn--danger" @click="confirmRemove(item)">Удалить</button>
                </div>
            </article>
        </div>
        <p v-else class="admin__hint">Пока нет служений.</p>
    </div>
</template>

<style src="./admin.css"></style>
