<template>
    <Header v-if="!isAuthPage" />

    <router-view></router-view>
</template>

<script>
    import Header from './UI/Header.vue'
    import router from '../router'
    import { computed } from 'vue'

    export default {
        components: {Header},

        setup() {
            const isAuthPage = computed(() => {
                return router.currentRoute?.value?.name === 'login' || router.currentRoute?.value?.name === 'register'
            })

            return {
                isAuthPage,
            }
        }
    }
</script>
