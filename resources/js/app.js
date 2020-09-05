/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

import App from './components/App';
import router from './router';
import store from './store';

global.store = store;
global.router = router;

Vue.use(router);
Vue.use(Vuetify, {
    options: {
        themeVariations: ['primary', 'secondary', 'accent'],
        extra: {
        mainToolbar: {
            color: 'primary',
        },
        sideToolbar: {
        },
        sideNav: 'primary',
        mainNav: 'grey lighten-1',
        bodyBg: '',
        }
    }
});
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App }
});

export default app;
