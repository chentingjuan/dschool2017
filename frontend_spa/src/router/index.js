import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
// Vue.component('example', require('./components/Example.vue'));
// Vue.component('Navbar', require('../components/Navbar.vue'));

import comHomepage from "../components/Homepage.vue"
var Homepage = Vue.component('Homepage',comHomepage)

import page_index from "../components/Pages/page_index.vue"
import page_implement from "../components/Pages/page_implement.vue"
import page_news from "../components/Pages/page_news.vue"
import page_course from "../components/Pages/page_course.vue"
import page_post from "../components/Pages/page_post.vue"
import page_service from "../components/Pages/page_service.vue"
import page_about from "../components/Pages/page_about.vue"
import page_nav from "../components/Pages/page_nav.vue"
import page_question from "../components/Pages/page_question.vue"
import page_equipment from "../components/Equipment/EquipmentList.vue"
import page_style from "../components/Pages/page_style.vue"
import page_my_equipment from "../components/Equipment/MyEquipment.vue"

import ActivitySmall from "../components/Activity/ActivitySmall.vue"
import ActivityList from "../components/Activity/ActivityList.vue"
import routes_manage from "./routes_manage"

const routes = [
  { path: '/style', component: page_style },

  { path: '/nav', component: page_nav },

  { path: '/', component: page_index },
  { path: '/service', component: page_service },
  { path: '/course', component: page_course },
  { path: '/service/equipment', component: page_equipment },
  { path: '/about', component: page_about },
  { path: '/question', component: page_question },
  { path: '/implement', component: page_implement },
  { path: '/news', component: page_news },
  { path: '/news/:title', component: page_post, props: true },
  
  { path: '/activity/:event_id', component: ActivitySmall ,props: true},
  { path: '/activity', component: ActivityList ,props: true},
  { path: '/my/activity', component: Homepage },
  { path: '/my/equipment', component: page_my_equipment },
  

  routes_manage,

  { path: '*', component: Homepage, meta: { title: "首頁" } }
];

//
// ─── ROUTER OBJECT ──────────────────────────────────────────────────────────────
//


const router = new VueRouter({
  routes,
  base: "/",
  mode: "history",
  // scrollBehavior(to, from, savedPosition) {
  //   return new Promise((resolve, reject) => {
  //     setTimeout(() => {
  //       if (savedPosition) {
  //         resolve(savedPosition)
  //       } else {
  //         resolve({ x: 0, y: 0 })
  //       }
  //     }, 500)
  //   })
    
  // }
})

import store from "../store"

var savePositions={}

//跳轉前設定切換標題與跳頁
router.beforeEach((to, from, next) => {
  console.log(to);
  if (to.path.indexOf("/manage")==0){
    window.softScrollDisable = true
  } else {
    window.softScrollDisable = false
  }
 
  savePositions[from.path] = $(window).scrollTop()


  if (to.path=="/about" && to.hash=="#section_about_log"){

    // setTimeout(function(){
    //   // $("html, body").animate({ scrollTop: $(".section_log").offset().top-100  }, "slow");
    // },waittime);
  }else{
    // $("html, body").animate({ scrollTop: 0 }, "slow");
  }
  if (to.path=="/activity"){
    store.dispatch("loadEvents")
  }
  next();
});

//送出pageview
router.afterEach((route) => {
  if (window.ga){
    ga('send', 'pageview',route.path);
  }
  if (savePositions[route.path]) {
    setTimeout(function () {
      // window.scrollTo(0, savePositions[route.path])
      console.log("Scroll To Saved Path:" + savePositions[route.path])
      $("html, body").animate({ scrollTop:  savePositions[route.path] }, 50);
    },600)
  } else {
    setTimeout(function () {
      // window.scrollTo(0, savePositions[route.path])
      console.log("Scroll To 0")
      $("html, body").animate({ scrollTop:  0 }, 50);
    }, 600)

  }

  
});

export default router