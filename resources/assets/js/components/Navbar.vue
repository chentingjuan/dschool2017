<template lang="pug">
  nav.navbar.navbar-default.navbar-fixed-top
    .container
      .navbar-header
        // Collapsed Hamburger
        button.navbar-toggle.collapsed(type='button', data-toggle='collapse', data-target='#app-navbar-collapse')
          span.sr-only Toggle Navigation
          span.icon-bar
          span.icon-bar
          span.icon-bar

        // Branding Image
        a.navbar-brand(href="/" v-if="reallink")
          img(src='http://dschool.ntu.edu.tw/2017/assets/index__pageLogo.svg')
          span D-school台大創新設計學院
        router-link.navbar-brand(to="/" v-else)
          img(src='http://dschool.ntu.edu.tw/2017/assets/index__pageLogo.svg')
          span D-school台大創新設計學院

      #app-navbar-collapse.collapse.navbar-collapse
        // Left Side Of Navbar
        ul.nav.navbar-nav
          li
            a(href="/my/activity" v-if="reallink") 我的活動
            router-link(to="/my/activity" v-if="!reallink") 我的活動
          li
            a(href="/activity" v-if="reallink") 學院活動
            router-link(to="/activity" v-if="!reallink") 學院活動

          li(v-if="is_admin")
            a(href="/implement" v-if="reallink") 實作中心
            router-link(to="/implement" v-if="!reallink") 實作中心

          li(v-if="is_admin")
            a(href="/manage/user" v-if="reallink") 會員清單
            router-link(to="/manage/user" v-if="!reallink") 會員清單

        // Right Side Of Navbar
        ul.nav.navbar-nav.navbar-right
          // Authentication Links
          li
            a(href="/login", v-if = "!user") 登入 {{user}}
          li
            a(href="/register" , v-if = "!user") 註冊

          li.dropdown(v-if="user")
            a.dropdown-toggle(href='#', data-toggle='dropdown', role='button', aria-expanded='false')
              | {{user? user.name: ""}} {{user && user.admingroup=='root' ? ' [管理員]':'' }}
              span.caret
            ul.dropdown-menu(role='menu')
              li
                a(href="/login") 登出
                //- div(onclick="event.preventDefault();document.getElementById('logout-form').submit();") 登出
                //- form#logout-form(action="/logout" method="POST" style="display: none;")
                  input(type="hidden" name="_token" :value="csrf_token")
</template>


<script>
import {mapState,mapMutations} from 'vuex'
export default {
  props: ['reallink'],
  data(){
    return {}
  },
  computed:{
    ...mapState(['user','csrf_token']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    }
  },
  methods: {
    ...mapMutations(['set_user']),
    logout(){
      axios.post("/logout",{
        "_token": this.csrf_token
      }).then((res)=>{
        console.log(res.data);
        this.set_user(null);
      })
    }
  }
}
</script>
<style lang="sass?indentedSyntax">
.nav.navbar-nav a
  transition: 0.5s
  border-bottom: solid 3px transparent
  
  &.router-link-exact-active
    border-bottom: solid 3px #f95356
    background-color: #eee
.navbar-brand
  img
    margin-right: 10px
    display: inline-block
    height: 25px
</style>
