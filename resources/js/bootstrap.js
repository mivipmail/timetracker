import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

import router from './router';

window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 419 || error.response?.status === 401) {
            const routeName = router.currentRoute?.value?.name
            
            if (routeName !== 'login' && routeName !== 'register') {
                router.push({name: 'login'})
            }
        }

        return Promise.reject(error)
    }
)
