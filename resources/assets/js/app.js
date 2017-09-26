
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from "./store"
import router from "./router"
import {mapState} from "vuex"
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './components/App.vue'
Vue.component('App', App);
import Navbar from './components/Navbar.vue'
Vue.component('Navbar', Navbar);
import Clients from  './components/passport/Clients.vue'
import AuthorizedClients from './components/passport/AuthorizedClients.vue'
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue'

//passport
Vue.component(
    'passport-clients',
    Clients
);

Vue.component(
    'passport-authorized-clients',
    AuthorizedClients
);

Vue.component(
    'passport-personal-access-tokens',
    PersonalAccessTokens
);

const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
        registerMode: "normal"
    }
});

