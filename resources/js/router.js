import { createRouter } from "vue-router";
import { createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/register', component: () => import('./components/Auth/Register.vue'),
            name: 'register',
        },
        {
            path: '/login', component: () => import('./components/Auth/Login.vue'),
            name: 'login',
        },
        {
            path: '/', component: () => import('./components/Projects/Projects.vue'),
            name: 'projects.index',
        },
        {
            path: '/projects/create', component: () => import('./components/Projects/EditProject.vue'),
            name: 'projects.create',
        },
        {
            path: '/projects/edit/:id', component: () => import('./components/Projects/EditProject.vue'),
            name: 'projects.edit',
        },
        {
            path: '/projects/:id', component: () => import('./components/Projects/ShowProject.vue'),
            name: 'projects.show',
        },
        { 
            path: '/404', component: () => import('./components/NotFound.vue'),
            name: 'page404'
        },
        {
            path: '/:catchAll(.*)', redirect: '/404',
        },
    ],
})

export default router
