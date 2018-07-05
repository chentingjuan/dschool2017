<template lang="pug">
  nav.navbar.navbar-default.navbar-fixed-top(:class="{ 'at_top':scrollTop<=0, 'navbar-fixed-top': fixed }")
    .container-fluid
      .navbar-header
        // Collapsed Hamburger
        button.navbar-toggle.collapsed(type='button', data-toggle='collapse', data-target='#app-navbar-collapse')
          span.sr-only Toggle Navigation
          span.icon-bar
          span.icon-bar
          span.icon-bar

        router-link.navbar-brand(to="/")
          img(src='/static/img/index__pageLogo.svg')
          img.orange(src='/static/img/index__pageLogoOrange.svg')
          //span D-school@NTU

      #app-navbar-collapse.collapse.navbar-collapse(@click="toggleNav")

        // Right Side Of Navbar
        ul.nav.navbar-nav.navbar-right
          li
            router-link(to="/about" v-if="!reallink") 關於學院
          li
            router-link(to="/news" v-if="!reallink") 最新消息
          li
            router-link(to="/activity" v-if="!reallink") 學院活動
          li
            router-link(to="/course" v-if="!reallink") 課程介紹
          li(v-if="is_admin")
            router-link(to="/implement" v-if="!reallink") 實作中心
          li(v-if="is_admin")
            router-link(to="/service" v-if="!reallink") 服務
          li
            router-link(to="/question" v-if="!reallink") 常見問題

          // Authentication Links
          li
            a(href="/login", v-if = "!user") 登入 {{user}}
          li
            a(href="/register" , v-if = "!user") 註冊

          li.dropdown(v-if="user")
            a.dropdown-toggle(href='#', data-toggle='dropdown', role='button', aria-expanded='false')
              | {{user? user.name: ""}} 
              | {{user && user.admingroup=='root' ? '':'' }}
              span.caret
            ul.dropdown-menu(role='menu')
                  
              li
                router-link(to="/my/activity" v-if="!reallink") 我的活動
              li
                router-link(to="/my/equipment" v-if="!reallink") 我的借用
              li(v-if="is_admin")
                router-link(to="/manage/user" v-if="!reallink") 會員清單
              li(v-if="is_admin")
                router-link(to="/manage/equipment/list" v-if="!reallink") 借用管理
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
    ...mapState(['user','csrf_token','scrollTop']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    },
    fixed(){
      //只要不是管理介面都使用fixed的導覽列
      return ['/login','/manage'].every(route=>this.$route.path.indexOf(route)!=0) 
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
    },toggleNav(){
      $(".navbar-collapse").collapse('hide');
    },
  }
}
</script>
<style lang="sass">

</style>
