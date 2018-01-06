<template lang="pug">
.page.page_nav(:class="{is_opened: is_opened}")
  .mouseCircle(:class="{onItem:mouseOnItem}")
  .expandbtn(@click="is_opened=!is_opened",
            :class="{is_opened: is_opened}")
    .icon-bar
    .icon-bar()
  .questionbtn(@click="is_opened=false")
    router-link(to="/question") ?
  router-link.navbar-brand(to="/")
    div.wrapper
      img.white(src='/img/index__pageLogo.svg')
      img(src='/img/index__pageLogoOrange.svg')
      div(:class="{is_opened: is_opened}")
        transition(name="fadeNormal", mode="out-in")
          .nowpage(v-for="n in [nowPageName]", :key="$route.path")
            span {{nowPageName}}
  nav.theme.blue(:class="{is_opened: is_opened}")
    ul.navlists
      li(v-for="item in navlist", @click="is_opened=!is_opened") 
        router-link(:to="item.to") {{item.label}}

      li.panelUser
        a.dropdown-toggle.name(v-if="user",href='#', data-toggle='dropdown', role='button', aria-expanded='false')
          | {{user? user.name: ""}} 
          | {{user && user.admingroup=='root' ? '':'' }}
        ul.userFunc(@click="is_opened=!is_opened")
          li
            a(href="/login", v-if = "!user") 登入
          li
            a(href="/register" , v-if = "!user") 註冊
          li
            router-link(v-if="user",to="/my/activity") 我的活動
          li
            router-link(v-if="user",to="/my/equipment") 我的借用
          li(v-if="user && is_admin")
            router-link(to="/manage/user") 會員清單
          li(v-if="user && is_admin")
            router-link(to="/manage/equipment/list") 借用管理
          li(v-if="user")
            a(href="/login") 登出
</template>

<script>
import {mapState,mapMutations} from 'vuex'
export default {
  props: ['reallink'],
  data(){
    return {
      mouseOnItem: false,
      is_opened: true,
      navlist: [
        {
          label: "關於學院",
          to: "/about",
          is_admin: false
        },{
          label: "最新消息",
          to: "/news",
          is_admin: false
        },{
          label: "學院活動",
          to: "/activity",
          is_admin: false
        },{
          label: "課程介紹",
          to: "/course",
          is_admin: false
        },{
          label: "實作中心",
          to: "/implement",
          is_admin: true
        },{
          label: "服務",
          to: "/service",
          is_admin: true
        },{
          label: "常見問題",
          to: "/question",
          is_admin: false
        }
      ]
    }
  },
  computed:{
    ...mapState(['user','csrf_token','scrollTop']),
    nowPageName(){
      switch(this.$route.path){
        case "/about": 
          return "關於我們"
        case "/news": 
          return "最新消息"
        case "/activity": 
          return "學院活動"
        case "/course": 
          return "課程介紹"
        case "/implement": 
          return "實作中心"
        case "/service": 
          return "學院服務"
        case "/implement": 
          return "實作中心"
        case "/question": 
          return "常見問題"
        case "/my/activity": 
          return "我的活動"

      }

    },
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
  },
  mounted(){
    $(window).mousemove(function(evt){
      console.log(evt)
      $(".mouseCircle").css("left",evt.pageX)
      $(".mouseCircle").css("top",evt.pageY)
    })
    let _this=this
    $(window).hover(function(){
      _this.mouseOnItem=true
    },function(){
      _this.mouseOnItem=false

    })
  }
}
</script>

<style>

</style>
