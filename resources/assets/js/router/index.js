//components

// Vue.component('slick', Slick);
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
// Vue.component('example', require('./components/Example.vue'));
// Vue.component('Navbar', require('../components/Navbar.vue'));

import comManageActivity from "../components/Manage/Activity.vue"
var ManageActivity = Vue.component('ManageActivity',comManageActivity)


import comManageActivitEdit from "../components/Manage/ActivityEdit.vue"
var ManageActivitEdit = Vue.component('ManageActivitEdit',comManageActivitEdit)

import comManageUser from "../components/Manage/User.vue"
var ManageUser = Vue.component('ManageUser',comManageActivitEdit)

import comActivitySmall from "../components/Activity/ActivitySmall.vue"
var ActivitySmall = Vue.component('ActivitySmall',comActivitySmall)


import comActivityList from "../components/Activity/ActivityList.vue"
var ActivityList = Vue.component('ActivityList',comActivityList)


import comPostList from "../components/Manage/PostList.vue"
var ManagePostList = Vue.component('PostList', comPostList)

import comPostEdit from "../components/Manage/Post.vue"
var ManagePostEdit = Vue.component('PostEdit', comPostEdit)


import comHomepage from "../components/Homepage.vue"
var Homepage = Vue.component('Homepage',comHomepage)
// var page_index = Vue.component('page_index', require('../components/page_index.vue'));
// var page_about = Vue.component('page_about', require('../components/page_about.vue'));
// var page_member = Vue.component('page_member', require('../components/page_member.vue'));
// var page_news = Vue.component('page_news', require('../components/page_news.vue'));
// var page_product = Vue.component('page_product', require('../components/page_product.vue'));
// // var page_tech = Vue.component('page_tech', require('../components/page_tech.vue'));
// var page_post = Vue.component('page_post', require('../components/page_post.vue'));
// var page_job = Vue.component('page_job', require('../components/page_job.vue'));
// var page_contact = Vue.component('page_contact', require('../components/page_contact.vue'));
// var page_tern = Vue.component('page_tern', require('../components/page_tern.vue'));

// var section_footer = Vue.component('section_footer', require('../components/section_footer.vue'));
// // var section_solutions = Vue.component('section_solutions', require('../components/section_solutions.vue'));
// var section_search = Vue.component('section_search', require('../components/section_search.vue'));
//routes


import page_implement from "../components/Pages/page_implement.vue"
import page_news from "../components/Pages/page_news.vue"
import page_post from "../components/Pages/page_post.vue"

const routes = [
  { path: '/', component: Homepage },
  { path: '/implement', component: page_implement },
  { path: '/news', component: page_news },
  { path: '/news/:title', component: page_post, props: true },

  { path: '/manage/post', component: ManagePostList },
  { path: '/manage/post/:post_id', component: ManagePostEdit, props: true },
  { path: '/manage/activity/new', component: comManageActivitEdit},
  { path: '/manage/activity/:event_id/list', component: ManageActivity ,props: true},
  { path: '/manage/activity/:event_id', component: comManageActivitEdit ,props: true},
  { path: '/manage/user', component: comManageUser ,props: true},
  { path: '/activity/:event_id', component: ActivitySmall ,props: true},
  { path: '/activity', component: comActivityList ,props: true},
  { path: '/my/activity', component: Homepage},
  { path: '*', component: Homepage, meta: { title: "首頁" } }
];

const router = new VueRouter({
  routes,
  base: "/",
  mode: "history"
})

import store from "../store"

//跳轉前設定切換標題與跳頁
router.beforeEach((to, from, next) => {
  console.log(to);
  var waittime=600;
  if (to.path==from.path){
    waittime=50;
  }
  if (to.path=="/about" && to.hash=="#section_about_log"){

    setTimeout(function(){
      $("html, body").animate({ scrollTop: $(".section_log").offset().top-100  }, "slow");
    },waittime);
  }else{
    $("html, body").animate({ scrollTop: 0 }, "slow");
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
});

export default router