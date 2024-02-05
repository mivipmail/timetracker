<template>
    <Transition>
        <div v-if="isTaskDlg" class="d-block modal show">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Создать задачу</h5>
                        <button @click.prevent="onSoftClose" type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Название</label>
                            <input v-model="task.title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Введите название задачи">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
                            <textarea v-model="task.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click.prevent="onSoftClose" type="button" class="btn btn-otline-primary">Закрыть</button>
                        <button @click.prevent="() => onSaveTask(task)" 
                                :disabled="!task.title"
                                type="button" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script>
import { ref, onMounted } from 'vue'
import Header from '../UI/Header.vue'

export default {
    props: ['task', 'onSaveTask', 'onClose'],
    components: {Header},

    setup(props) {
        const isTaskDlg = ref(false)
        const task = ref({
                id: props.task.id ?? null,
                title: props.task.title ?? null,
                description: props.task.description ?? null,
            })

        const onSoftClose = () => {
            isTaskDlg.value = false
            setTimeout(props.onClose, 300)
        }
        
        onMounted(() => {
            isTaskDlg.value = true
        })

        return {
            isTaskDlg,
            task,
            onSaveTask: props.onSaveTask,
            onSoftClose,
        }
    },
}
</script>

<style scoped>
    .v-enter-active,
    .v-leave-active {
    transition: opacity 0.5s ease;
    }

    .v-enter-from,
    .v-leave-to {
    opacity: 0;
    }
</style>
