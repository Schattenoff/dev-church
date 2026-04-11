<script>
import { api } from '@/config/fetch.js'
import Input from '@/modules/ui/input/Input.vue'
import Button from '@/modules/ui/button/Button.vue'
import Modal from '@/modules/ui/modal/Modal.vue'

function empty() {
    return
}

export default {
    name: 'ScheduleAdmin',

    components: { Input, Button, Modal },

    data() {
        return {
            schedule: [],
            isReady: false,
            showForm: false,
            editingDay: null,
            editingId: null,
            form: {
                time: '',
                title: ''
            },
        }
    },

    mounted() {
        this.getData()
    },

    methods: {
        onResetForm() {
            return {
                time: '',
                title: ''
            }
        },

        getData() {
            api.fetch('/schedule/get', null, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                this.schedule = res.schedule
                this.isReady = true
            })
        },
        startCreate(day) {
            this.editingDay = day
            this.editingId = null
            this.form = this.onResetForm()
            this.showForm = true
        },
        startEdit(day, event) {
            this.editingDay = day
            this.editingId = event.id
            this.form = { time: event.time, title: event.title }
            this.showForm = true
        },
        cancel() {
            this.showForm = false
            this.editingDay = null
            this.editingId = null
            this.form = this.onResetForm()
        },
        onSave() {
            if (!this.form.title.trim() || !this.form.time.trim()) return

            const payload = {
                data: {
                    time: this.form.time,
                    title: this.form.title,
                },
            }
            if (this.editingId) {
                payload.data.id = this.editingId
            } else {
                payload.data.day = this.editingDay
            }

            api.fetch('/schedule/save', payload, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                api.growl('Сохранено', 'success')
                this.cancel()
                this.getData()
            })
        },
        onDelete(day, event) {
            if (!window.confirm(`Удалить «${event.title}»?`)) return
            api.fetch('/schedule/delete', { data: { id: event.id } }, (res) => {
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
            <h1 class="admin__title">Расписание</h1>
        </div>
        <p class="admin__hint">Добавляйте и редактируйте служения по дням недели.</p>

        <div class="scheduleAdmin">
            <section v-for="col in schedule" :key="col.day" class="scheduleAdmin__day">
                <header class="scheduleAdmin__dayHeader">
                    <h2 class="scheduleAdmin__dayTitle">{{ col.day }}</h2>
                    <button class="scheduleAdmin__addBtn" @click="startCreate(col.day)">+ Добавить</button>
                </header>
                <ul v-if="col.events.length" class="scheduleAdmin__events">
                    <li
                        v-for="event in col.events"
                        :key="event.id"
                        class="scheduleAdmin__event"
                    >
                        <div class="scheduleAdmin__eventInfo">
                            <span class="scheduleAdmin__eventTime">{{ event.time }}</span>
                            <span class="scheduleAdmin__eventTitle">{{ event.title }}</span>
                        </div>
                        <div class="scheduleAdmin__eventActions">
                            <button class="adminItem__btn" @click="startEdit(col.day, event)">Редактировать</button>
                            <button class="adminItem__btn adminItem__btn--danger" @click="onDelete(col.day, event)">Удалить</button>
                        </div>
                    </li>
                </ul>
                <p v-else class="scheduleAdmin__empty">Нет событий</p>
            </section>
        </div>

        <Modal
            :open="showForm"
            :title="editingId ? 'Редактировать событие' : `Новое событие — ${editingDay}`"
            @close="cancel"
        >
            <form class="admin__form" @submit.prevent="onSave">
                <Input label="Время" v-model="form.time" placeholder="Например: 19:00" />
                <Input label="Название" v-model="form.title" placeholder="Например: Молитва" />
                <div class="admin__formActions">
                    <Button :label="editingId ? 'Сохранить' : 'Добавить'" variant="filled" />
                    <Button label="Отмена" variant="outlined" @click="cancel" />
                </div>
            </form>
        </Modal>
    </div>
</template>

<style src="./admin.css"></style>
