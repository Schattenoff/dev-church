<script>
import { authStore } from '@/composables/useAuth.js'
import Input from '@/modules/ui/input/Input.vue'
import Button from '@/modules/ui/button/Button.vue'

export default {
    name: 'AdminLogin',
    components: { Input, Button },
    data() {
        return {
            username: '',
            password: '',
            error: '',
        }
    },
    methods: {
        onSubmit() {
            this.error = ''
            if (authStore.login(this.username, this.password)) {
                const redirect = this.$route.query.redirect
                this.$router.push(typeof redirect === 'string' ? redirect : '/admin')
            } else {
                this.error = 'Неверный логин или пароль'
            }
        },
    },
}
</script>

<template>
    <div class="login">
        <form class="login__card" @submit.prevent="onSubmit">
            <h1 class="login__title">Вход в админку</h1>
            <Input label="Логин" v-model="username" placeholder="admin" />
            <Input label="Пароль" type="password" v-model="password" placeholder="admin" />
            <p v-if="error" class="login__error">{{ error }}</p>
            <Button label="Войти" variant="filled" />
            <router-link to="/" class="login__back">← На главную</router-link>
        </form>
    </div>
</template>

<style src="./admin.css"></style>
