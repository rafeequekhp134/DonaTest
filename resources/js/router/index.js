import Vue from 'vue'
    import VueRouter from 'vue-router'

    Vue.use(VueRouter)

    // import App from './components/App'
    import Welcome from './../components/Welcome'
    import Login from './../components/login'
    import Register from './../components/register'
    import Dashboard from './../components/dashboard'

    const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'home',
                component: Welcome,
                meta: { title: 'Home' }
            },
            {
                path: '/#/login',
                name: 'login',
                component: Login
            },
            {
                path: '/#/register',
                name: 'register',
                component: Register
            },
            {
                path: '/#/dashboard',
                name: 'dashboard',
                component: Dashboard
            },
        ],
    })

    export default router;