export default function useAuthAPI() {
    const register = (formData) => {
        return axios.get('/sanctum/csrf-cookie').then(response => {
            return axios.post('/api/register', formData)
                .then(res => {
                    return res.data
                })
        })
    }

    const login = (formData) => {
        return axios.get('/sanctum/csrf-cookie').then(response => {
            return axios.post('/api/login', formData)
                .then(res => {
                    return res.data
                })
        })
    }

    const logout = () => {
        return axios.post('/api/logout')
            .then(res => {
                return res.data
            })
    }

    const fetchUser = () => {
        return axios.get(`/api/auth-user`)
            .then(res => {
                return res.data
            })
    }

    return {
        register,
        login,
        logout,
        fetchUser,
    }
}