
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// console.log(process.env.NODE_ENV)

require('./bootstrap');

import store from "./store"
import router from "./router"
import {mapState} from "vuex"
import schoolData from './dataSchools'
window.Vue = require('vue');
import VueAnalytics from 'vue-analytics'
import VueParallaxJs from 'vue-parallax-js'
Vue.use(VueParallaxJs)

import ElementUI from 'element-ui'
Vue.use(ElementUI)

var softScroll=true
import soft_scroll from './plugins/soft_scroll'
softScroll && soft_scroll.init()


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


if (document.domain != "dschool2017.dev") {
    Vue.use(VueAnalytics, {
        id: 'UA-52977512-22',
        router
    })
}


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
                  return { status: txt, label: "待確認", open: true, registed: true }
            case "CONFIRMED":
                  return { status: txt, label: "已確認報名", open: true, registed: true }
            case 'registed':
                  return { status: txt, label: "已報名", open: false ,registed: true}
            case 'need login':
                  return { status: txt, label: "登入後報名", open: false, registed: false}
            case 'not_open':
                  return { status: txt, label: "非可報名期間", open: false, registed: false}
          }
            return { status: txt, label: "未報名", open: true, registed: false}
        },
        get_event_confirm_type_translate(txt){
            switch (txt) {
                case "yes":
                    return { status: txt, label: "錄取", symbol: "✓"}
                case "no":
                    return { status: txt, label: "不錄取", symbol:  "☓"}
                case 'pending':
                    return { status: txt, label: "備取", symbol: "△"}
            }
            return { status: txt, label: "", symbol: "-" }
        },
        get_equipment_confirm_type_translate(txt) {
            switch (txt) {
                case "unconfirmed":
                    return { status: txt, label: "未審核", symbol: "-"}
                case "yes":
                    return { status: txt, label: "已核准", symbol: "✓"}
                case 'no':
                    return { status: txt, label: "不核准", symbol: "☓"}
            }
            return { status: txt, label: "", symbol: "-" }
        },
        handleImageAdded(file, Editor, cursorLocation) {
            // An example of using FormData
            // NOTE: Your key could be different such as:
            // formData.append('file', file)
            console.log("get picture!")
            var formData = new FormData();
            formData.append('file', file)
            console.log(file)

            axios({
                url: '/api/upload',
                method: 'POST',
                data: formData
            })
                .then((result) => {
                    let url = result.data // Get url from response
                    Editor.insertEmbed(cursorLocation, 'image', url);
                })
                .catch((err) => {
                    console.log(err);
                })
        },
        cssbg(url) {
            let result = {
                'background-image': `url("${url}")`
            }
            // console.log(result)
            return result
        },
        scrollTo(cname,custon_option) {
            let options = Object.assign({
                pan: 0
            },
                custon_option
            )
            $("html,body").animate({ scrollTop: $(cname).offset().top + options.pan})
        },

    }
})

$(window).scroll(()=>{
    store.commit("setScrollTop",window.scrollY)
})


var timer = setTimeout(() => {
    store.commit("setLoading", false)
    clearTimeout(timer)
}, 2000);

window.onload = function () {
    if (!timer){
        store.commit("setLoading", false)
    }
}

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

