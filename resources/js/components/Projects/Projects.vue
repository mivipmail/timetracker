<template>
    <Loading v-if="!projects" />

    <div v-if="projects" class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h2 class="h2 mb-5">Проекты</h2>
                <div class="d-flex justify-content-end mb-3">
                    <router-link :to="{name: 'projects.create'}" class="btn btn-primary" type="submit">Создать проект</router-link>
                </div>
                <div class="list-group">
                    <router-link v-for="project in projects" :key="project.id"
                                :to="{name: 'projects.show', params: {id: project.id}}" 
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">#{{ project.id }} {{ project.title }}</div>
                            <small class="text-secondary fs-6">{{ project.created_at }}</small>
                        </div>
                        <div v-if="project.tasks_count" class="d-flex flex-column align-items-end">
                            <div>Активных задач <span class="badge bg-primary rounded-pill">
                                {{ project.active_tasks_count }} <span class="fw-normal">| {{ project.tasks_count }}</span></span>
                            </div>
                            <div>
                                <small>Затраченное время: {{ project.tasks_sum_time }}</small>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../UI/Loading.vue'
import useProjectAPI from '../../composables/useProjectAPI.js'
import {ref, onMounted} from 'vue'

export default {
    components: {Loading},

    setup() {
        const projects = ref(null)
        const {fetchProjects} = useProjectAPI()

        onMounted(() => {
            fetchProjects()
                .then(data => projects.value = data)
                .catch(err => console.log(err.response?.data?.message))
        })

        return {
            projects,
        }
    },
}
</script>
<style scoped>
</style>
