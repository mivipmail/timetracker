<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Вход</div>

                    <div class="card-body">
                        <form method="POST">
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
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input v-model="formData.remember" class="form-check-input" type="checkbox" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Запомнить
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <span class="text-danger" role="alert">
                                        <strong>{{ message }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button @click.prevent="onLogin" 
                                            :disabled="isSending || !formData.login || !formData.password"
                                            type="submit" 
                                            class="btn btn-primary">
                                        Войти
                                    </button>
                                    <router-link :to="{ name: 'register' }" class="d-inline-block mx-3">Зарегистрироваться</router-link>
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
        const {login} = useAuthAPI()

        const formData = ref({
            login: null,
            password: null,
            remember: false,
        })

        const errors = ref(null)
        const message = ref(null)

        const isSending = ref(false)

        const onLogin = () => {
            errors.value = null
            message.value = null
            isSending.value = true

            login(formData.value)
                .then(data => router.push({name: 'projects.index'}))
                .catch(err => {
                    errors.value = err.response?.data?.errors
                    if (!err.response?.data?.errors)
                        message.value = err.response?.data?.message
                })
                .finally(() => isSending.value = false)
        }

        return {
            formData,
            errors,
            message,
            isSending,
            onLogin,
        }
    },
}
</script>
<style scoped>
</style>
