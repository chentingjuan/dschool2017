
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from "./store"
import router from "./router"
import {mapState} from "vuex"
import schoolData from './dataSchools'
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
              return {label: "待確認",open: true}
            case "CONFIRMED":
            case 'registed':
              return { label: "已確認報名", open: false }
            case 'need login':
              return { label: "請登入後報名", open: false }
            case 'not_open':
              return { label: "非可報名期間", open: false }
          }
          return { label: "未報名", open: true }
        },
    }
})

$(window).scroll(()=>{
    store.commit("setScrollTop",window.scrollY)
})

const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
        registerMode: "student",
        schoolData
    },
    mounted(){
        store.dispatch('loadWebsite')
    }
});

