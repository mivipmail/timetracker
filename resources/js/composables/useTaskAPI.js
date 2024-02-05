export default function useTaskAPI() {
    const fetchTasks = (projectId) => {
        return axios.get(`/api/tasks/${projectId}`)
            .then(res => {
                return res.data
            })
    }

    const fetchTask = (id) => {
        return axios.get(`/api/tasks/${id}`)
            .then(res => {
                return res.data
            })
    }

    const createTask = (formData) => {
        return axios.post('/api/tasks', formData)
            .then(res => {
                return res.data
            })
    }

    const updateTask = (id, formData) => {
        return axios.patch(`/api/tasks/${id}`, formData) 
            .then(res => {
                return res.data
            })
    }

    const deleteTask = (id) => {
        return axios.delete(`/api/tasks/${id}`) 
            .then(res => {
                return res.data
            })
    }

    const startTask = (id) => {
        return axios.patch(`/api/tasks/start/${id}`) 
            .then(res => {
                return res.data
            })
    }

    const stopTask = (id) => {
        return axios.patch(`/api/tasks/stop/${id}`) 
            .then(res => {
                return res.data
            })
    }

    return {
        fetchTasks,
        fetchTask,
        createTask,
        updateTask,
        deleteTask,
        startTask,
        stopTask,
    }
}