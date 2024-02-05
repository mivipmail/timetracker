<template>
    <nav v-if="user" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <router-link :to="{ name: 'projects.index' }" class="navbar-brand me-5">Вы: {{ user.name }}</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'projects.index' }" class="nav-link active">Проекты</router-link>
                    </li>
                    <!-- <li class="nav-item">
                        <router-link :to="{ name: 'projects.index' }" class="nav-link">Статистика</router-link>
                    </li> -->
                </ul>
                <div class="d-flex">
                    <button @click.prevent="onLogout" class="btn btn-outline-light">Выйти</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import useAuthAPI from '../../composables/useAuthAPI.js'
import router from '../../router'
import { ref, onMounted } from 'vue'

export default {

    setup() {
        const user = ref(null)
        const {logout, fetchUser} = useAuthAPI()

        const onLogout = () => {
            logout()
                .then(data => {
                    if (data.result === 'success')
                        router.push({name: 'login'})
                })
                .catch(err => console.log(err.response?.data?.message))
        }

        onMounted(() => {
            fetchUser()
                .then(data => user.value = data)
                .catch(err => console.log(err.response?.data?.message))
        })

        return {
            onLogout,
            user,
        }
    },
}
</script>

<style scoped>
</style>
