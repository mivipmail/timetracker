export default function useProjectAPI() {
    const fetchProjects = () => {
        return axios.get('/api/projects')
            .then(res => {
                // console.log(res.data)
                return res.data
            })
    }

    const fetchProject = (id) => {
        return axios.get(`/api/projects/${id}`)
            .then(res => {
                // console.log(res.data)
                return res.data
            })
    }

    const createProject = (formData) => {
        return axios.post('/api/projects', formData)
            .then(res => {
                return res.data
            })
    }

    const updateProject = (id, formData) => {
        return axios.patch(`/api/projects/${id}`, formData) 
            .then(res => {
                return res.data
            })
    }

    const deleteProject = (id) => {
        return axios.delete(`/api/projects/${id}`) 
            .then(res => {
                return res.data
            })
    }

    return {
        fetchProjects,
        fetchProject,
        createProject,
        updateProject,
        deleteProject,
    }
}