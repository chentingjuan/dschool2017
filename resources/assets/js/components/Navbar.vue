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
        a.navbar-brand(href="/" v-if="reallink") D-school 台大創新設計學院
        router-link.navbar-brand(to="/" v-else) D-school 台大創新設計學院

      #app-navbar-collapse.collapse.navbar-collapse
        // Left Side Of Navbar
        ul.nav.navbar-nav
          li
            a(href="/" v-if="reallink") 我的活動
            router-link(to="/" v-if="!reallink") 我的活動

        ul.nav.navbar-nav
          li
            a(href="/activity" v-if="reallink") 學院活動
            router-link(to="/activity" v-if="!reallink") 學院活動

        // Right Side Of Navbar
        ul.nav.navbar-nav.navbar-right
          // Authentication Links
          li
            a(href="/login", v-if = "!user") 登入 {{user}}
          li
            a(href="/register" , v-if = "!user") 註冊

          li.dropdown(v-if="user")
            a.dropdown-toggle(href='#', data-toggle='dropdown', role='button', aria-expanded='false')
              | {{user? user.name: ""}}
              span.caret
            ul.dropdown-menu(role='menu')
              li
                div(onclick="event.preventDefault();document.getElementById('logout-form').submit();") 登出
                form#logout-form(action="/logout" method="POST" style="display: none;")
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
    ...mapState(['user','csrf_token'])
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
