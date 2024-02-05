<template>
    <h3 class="h3 border-bottom bg-secondary bg-gradient text-white pt-1 pb-2 px-2 mb-5">Задачи по проекту</h3>

    <div class="d-flex justify-content-end mb-4">
        <button @click.prevent="() => taskToEdit = {}" 
                :disabled="isSending"
                class="btn btn-outline-primary btn-sm me-1">Создать задачу</button>
    </div>

    <div class="list-group">
        <div v-for="task in tasks" :key="task.id" 
                class="list-group-item list-group-item-action bg-light d-flex justify-content-between">
            <div class="d-flex flex-wrap flex-column align-items-end me-3">
                <button @click.prevent="() => taskToEdit = task" 
                        :disabled="isSending"
                        class="w-100 d-flex flex-wrap flex-grow-1 flex-column align-items-start border-0 shadow-0 bg-transparent">
                    <h6 class="h6 fw-bold text-start mb-1">{{ task.title }}</h6>
                    <small class="text-success text-start">{{ task.started_at ? ('В работе с ' + task.started_at) : '' }}</small>
                    <small class="text-start">
                        {{ showTaskDescriptionId !== task.id ? getCuttedStr(task.description, 200)/*(task.description.substr(0, 200).trim() + '...')*/ : task.description }}
                    </small>
                </button>
                <button v-if="showTaskDescriptionId !== task.id && task.description.length > 200" 
                        @click.prevent="() => showTaskDescriptionId = task.id" 
                        class="btn btn-link btn-sm">Показать</button>
                <button v-if="showTaskDescriptionId === task.id && task.description.length > 200" 
                        @click.prevent="() => showTaskDescriptionId = null" 
                        class="btn btn-link btn-sm">Скрыть</button>
            </div>
            <div class="d-flex flex-column align-items-end">
                <p class="mb-1"><small>Затраченное время: {{ task.time }}</small></p>
                <div class="btn-container d-flex flex-wrap justify-content-end">
                    <button v-if="task.started_at" 
                            @click.prevent="() => onStopTask(task.id)" 
                            :disabled="isSending"
                            class="btn btn-success btn-sm mb-1">Закончить выполнение</button>
                    <button v-else 
                            @click.prevent="() => onStartTask(task.id)" 
                            :disabled="isSending"
                            class="btn btn-outline-success btn-sm mb-1">Начать выполнение</button>
                    <button @click.prevent="() => onDeleteTask(task.id)" 
                            :disabled="isSending"
                            class="btn btn-outline-danger btn-sm mb-1 ms-1">Удалить</button>
                </div>
            </div>
        </div>
    </div>

    <EditTaskDlg v-if="taskToEdit" :task="taskToEdit" :onSaveTask="onSaveTask" :onClose="() => taskToEdit = null" />
</template>

<script>
import useTasksAPI from '../../composables/useTaskAPI.js'
import EditTaskDlg from './EditTaskDlg.vue'
import {ref} from 'vue'

export default {
    props: ['project', 'getProject'],
    components: {EditTaskDlg},

    setup(props) {
        const tasks = ref(props.project.tasks)
        const {createTask, updateTask, deleteTask, startTask, stopTask} = useTasksAPI()
        const taskToEdit = ref(null)
        const isSending = ref(false)

        const showTaskDescriptionId = ref(null)

        const onSaveTask = (task) => {
            taskToEdit.value = null
            let method, oldTask
            if (task.id) {
                oldTask = tasks.value.find(el => el.id === task.id)
                if (task.title === oldTask.title && task.description === oldTask.description) 
                    return
                else
                    method = () => updateTask(task.id, task)
            }
            else {
                task.project_id = props.project.id
                method = () => createTask(task)
            }

            isSending.value = true
            method()
                .then(data => getTasks())
                .catch(err => console.log(err.response?.data?.message))
                .finally(() => isSending.value = false)
        }

        const onDeleteTask = (id) => {
            isSending.value = true
            deleteTask(id)
                .then(data => getTasks())
                .catch(err => console.log(err.response?.data?.message))
                .finally(() => isSending.value = false)
        }

        const onStartTask = (id) => {
            isSending.value = true
            startTask(id)
                .then(data => getTasks())
                .catch(err => console.log(err.response?.data?.message))
                .finally(() => isSending.value = false)
        }

        const onStopTask = (id) => {
            isSending.value = true
            stopTask(id)
                .then(data => getTasks())
                .catch(err => console.log(err.response?.data?.message))
                .finally(() => isSending.value = false)
        }

        const getTasks = () => {
            props.getProject(true)
                .then(data => tasks.value = props.project.tasks)
        }

        const getCuttedStr = (str, length) => {
            return length < str.length
                ? str.substr(0, length).trim() + (str.length > length ? '...' : '')
                : str
        }

        return {
            tasks,
            isSending,
            taskToEdit,
            showTaskDescriptionId,
            onSaveTask,
            onDeleteTask,
            onStartTask,
            onStopTask,
            getCuttedStr,
        }
    },
}
</script>
<style scoped>
    .btn-container {
        min-width: 200px;
    }
</style>
