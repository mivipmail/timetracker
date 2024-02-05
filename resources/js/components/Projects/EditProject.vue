<template>
    <Loading v-if="isSending" />

    <div v-if="!isSending" class="container">
        <div class="row justify-content-center mt-5">
            <div class="d-flex justify-content-start mb-5">
                <router-link :to="{name: 'projects.index'}" class="link">К списку проектов</router-link>
            </div>
            <div class="col-md-8">
                <h2 class="h2 mb-5">{{ id ? `Редактировать проект #${id}` : 'Создать проект' }}</h2>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Название</label>
                    <input v-model="formData.title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Введите название проекта">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
                    <textarea v-model="formData.description" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <button @click.prevent="onBack" 
                            :disabled="isSending"
                            class="btn btn-outline-primary" type="button">Назад</button>
                    <button @click.prevent="saveProject" 
                            :disabled="isSending || !formData.title"
                            class="btn btn-primary" type="submit">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../UI/Loading.vue'
import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import useProjectAPI from '../../composables/useProjectAPI.js'
import router from '../../router'

export default {
    components: {Loading},

    setup() {
        const route = useRoute()
        const id = ref(route.params.id ?? null)
        const {fetchProject, createProject, updateProject} = useProjectAPI()
        const isSending = ref(false)

        const formData = ref({
            title: null,
            description: null,
        })

        const onBack = () => {
            router.back()
        }

        const saveProject = () => {
            const method = () => id.value ? updateProject(id.value, formData.value) : createProject(formData.value)

            isSending.value = true
            method()
                .then(data => {
                    if (data.id)
                       router.push({name: 'projects.show', params: {id: data.id}})
                })
                .catch(err => {
                    console.log(err.response?.data?.message)
                    if (err.response?.status === 404)
                        router.push({name: 'page404'})
                })
                .finally(() => isSending.value = false)
        }

        onMounted(() => {
            if (id.value) {
                isSending.value = true
                fetchProject(id.value)
                    .then(data => {
                        formData.value.title = data.title
                        formData.value.description = data.description
                    })
                    .catch(err => console.log(err.response?.data?.message))
                    .finally(() => isSending.value = false)
            }
        })

        return {
            id,
            formData,
            isSending,
            saveProject,
            onBack,
        }
    },
}
</script>
<style scoped>
</style>
