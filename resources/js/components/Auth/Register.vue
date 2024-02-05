<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Регистрация</div>

                    <div class="card-body">
                        <form method="POST">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>
                                <div class="col-md-6">
                                    <input v-model="formData.name" id="name" type="text" 
                                        :class="`form-control ${errors?.name ? 'is-invalid' : ''}`"
                                        placeholder="Введите имя">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ errors?.name?.[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="login" class="col-md-4 col-form-label text-md-end">Логин</label>
                                <div class="col-md-6">
                                    <input v-model="formData.login" id="login" type="login" 
                                        :class="`form-control ${errors?.login ? 'is-invalid' : ''}`"
                                        placeholder="Введите логин">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ errors?.login?.[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>
                                <div class="col-md-6">
                                    <input v-model="formData.password" id="password" type="password" 
                                        :class="`form-control ${errors?.password ? 'is-invalid' : ''}`"
                                        placeholder="Введите пароль">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ errors?.password?.[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Подтвердите пароль</label>
                                <div class="col-md-6">
                                    <input v-model="formData.password_confirmation" id="password-confirm" type="password" 
                                        :class="`form-control ${errors?.password_confirmation ? 'is-invalid' : ''}`"
                                        placeholder="Повторите пароль">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ errors?.password_confirmation?.[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button @click.prevent="onRegister" 
                                            :disabled="isSending || !formData.name || !formData.login || !formData.password || !formData.password_confirmation"
                                            type="submit" 
                                            class="btn btn-primary">
                                        Зарегистрироваться
                                    </button>
                                    <router-link :to="{ name: 'login' }" class="d-inline-block mx-3">Войти</router-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useAuthAPI from '../../composables/useAuthAPI.js'
import router from '../../router'
import { ref } from 'vue'

export default {

    setup() {
        const {register} = useAuthAPI()

        const formData = ref({
            name: null,
            login: null,
            password: null,
            password_confirmation: null,
        })

        const errors = ref(null)

        const isSending = ref(false)

        const onRegister = () => {
            errors.value = null
            isSending.value = true

            register(formData.value)
                .then(data => router.push({name: 'projects.index'}))
                .catch(err => errors.value = err.response?.data?.errors)
                .finally(() => isSending.value = false)
        }

        return {
            formData,
            errors,
            isSending,
            onRegister,
        }
    },
}
</script>
<style scoped>
</style>
