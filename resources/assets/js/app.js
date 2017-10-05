
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

Vue.mixin({
    methods: {
        strip_tags(txt){
            let result = (""+txt).replace(/(<([^>]+)>)/ig,"")
            return result
        },
        get_event_status_translate(txt){
          switch(txt){
            case "UNCONFIRMED":
              return "已報名待確認"
            case "CONFIRMED",'registed':
              return "已報名與確認"
          }
          return "未報名"
        },
    }
})

const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
        registerMode: "student"
    }
});

