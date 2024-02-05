<template>
    <Loading v-if="isSending" />

    <div v-if="!isSending" class="container">
        <div class="row justify-content-center mt-5">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex justify-content-start mb-5">
                    <router-link :to="{name: 'projects.index'}" class="link">К списку проектов</router-link>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <button @click.prevent="() => onDeleteProject(project.id)" class="btn btn-danger">Удалить проект</button>
                    <router-link :to="{name: 'projects.edit', params: {id: project.id}}" 
                                class="btn btn-primary ms-1" type="submit">Редактировать</router-link>
                </div>
            </div>
            <div class="col-md-8">
                <div class="d-flex flex-wrap justify-content-between align-items-end mb-3">
                    <h2 class="h2 me-5 mb-3">#{{ project.id }} {{ project.title }}</h2>
                    <p class="ms-auto mb-3">Общее затраченное время: {{ project.tasks_sum_time }}</p>
                </div>
                <div class="mb-5">
                    <div>{{ project.description }}</div>
                </div>

                <Tasks :project="project" :getProject="getProject" />
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../UI/Loading.vue'
import Tasks from '../Tasks/Tasks.vue'
import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import useProjectAPI from '../../composables/useProjectAPI.js'
import router from '../../router'

export default {
    components: {Loading, Tasks},

    setup() {
        const isSending = ref(true)
        const project = ref(null)
        const {fetchProject, deleteProject} = useProjectAPI()
        const route = useRoute()

        const onDeleteProject = (id) => {
            deleteProject(id)
                .then(data => {
                    if (data.result === 'success')
                        router.push({name: 'projects.index'})
                })
                .catch(err => {
                    console.log(err.response?.data?.message)
                    if (err.response?.status === 404)
                        router.push({name: 'page404'})
                })
        }

        const getProject = (isSilent = false) => {
            // if (route.params.id) {
                isSending.value = !isSilent
                return fetchProject(route.params.id) 
                    .then(data => project.value = data)
                    .catch(err => {
                        console.log(err.response?.data?.message)
                        if (err.response?.status === 404)
                            router.push({name: 'page404'})
                    })
                    .finally(() => isSending.value = false)
            // }
        }

        onMounted(() => {
            getProject()
        })

        return {
            project,
            isSending,
            onDeleteProject,
            getProject,
        }
    },
}
</script>

<style scoped>
</style>
