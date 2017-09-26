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
        router-link.navbar-brand(to="/") D-school 台大創新設計學院
      #app-navbar-collapse.collapse.navbar-collapse
        // Left Side Of Navbar
        ul.nav.navbar-nav
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
                a(@click="logout")
                  | 登出
                


</template>


<script>
import {mapState} from 'vuex'
export default {
  data(){
    return {
    }
  },
  computed:{
    ...mapState(['user'])
  },
  methods: {
    logout(){
      axios.post("/logout")
    }
  }
}
</script>
