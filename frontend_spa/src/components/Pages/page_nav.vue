<template lang="pug">
.page.page_nav(:class="{is_opened: is_opened}")
  .mouseCircle(:class="{onItem:mouseOnItem}")
  .user(@click="auth_open=true") 
    span(v-if='user' ) {{user.name}}
    span(v-else) 登入
  transition(name="fade")
    .auth_container(v-if="auth_open")
      .close(@click="auth_open=false")
      auth_panel(@onLogin="auth_open=false", @onClose="auth_open=false")
  .expandbtn(@click="is_opened=!is_opened",
            :class="{is_opened: is_opened}")
    .icon-bar
    .icon-bar()
  //.questionbtn(@click="is_opened=false")
    router-link(to="/question") ?
  router-link.navbar-brand(to="/")
    div.wrapper
      img.white(src='/static/img/index__pageLogo.svg')
      img(src='/static/img/index__pageLogoOrange.svg')
      div(:class="{is_opened: is_opened}")
        transition(name="fadeNormal", mode="out-in")
          .nowpage(v-for="n in [nowPageName]", :key="$route.path")
            span {{nowPageName}}
  nav.theme.blue(:class="{is_opened: is_opened}")
    .bg
    ul.navlists
      li(v-for="item in navlist", @click="is_opened=!is_opened") 
        router-link(:to="item.to") {{item.label}}

      li.panelUser
        a.name(v-if="user",href='#', data-toggle='dropdown', role='button', aria-expanded='false')
          | {{user? user.name: ""}} 
          | {{user && user.admingroup=='root' ? '':'' }}
        ul.userFunc(@click="is_opened=!is_opened" :key="is_opened").animated.fadeIn
          li
            span(href="/login", v-if = "!user" , @click="auth_open=true") 登入
          li
            span(href="/register" , v-if = "!user",  @click="auth_open=true") 註冊
          li
            router-link(v-if="user",to="/my/activity") 我的活動
          li
            router-link(v-if="user && is_admin",to="/manage/post") 網站管理
          //li
            router-link(v-if="user",to="/my/equipment") 我的借用
          li(v-if="user && is_admin")
            router-link(to="/manage/user") 會員清單
          //li(v-if="user && is_admin")
            router-link(to="/manage/equipment/list") 借用管理
          li(v-if="user")
            span(@click="logout") 登出
</template>

<script>
import {mapState,mapMutations,mapActions} from 'vuex'
import auth_panel from "@/components/panels/auth_panel.vue"

var PIXI = require('pixi.js');
export default {
  props: ['reallink'],
  components: {
    auth_panel
  },
  data(){
    return {
      mouseOnItem: false,
      is_opened: false,
      auth_open: false,
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
    ...mapState({
      user: state=>state.auth.user,
      scrollTop: 'scrollTop'
    }),
    nowPageName(){
      if (this.$route.fullPath.indexOf('/manage')==0){
        return ""
      }
      if(this.$route.path.indexOf("/activity")!=-1){
        return "學院活動"
      }
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
     ...mapActions({
      logout: 'auth/logout',
    }),
    toggleNav(){
      $(".navbar-collapse").collapse('hide');
    },
  },
  mounted(){
    var mousePos = {
      x: 0,
      y: 0
    }
    $(window).mousemove(function(evt){
      // console.log(evt)
      mousePos.x = evt.pageX
      mousePos.y = evt.pageY
      // $(".mouseCircle").css("left",evt.pageX)
      // $(".mouseCircle").css("top",evt.pageY)
    })
    let _this=this
    $(window).hover(function(){
      _this.mouseOnItem=true
    },function(){
      _this.mouseOnItem=false

    })



    // var ww = window.outerWidth
    // var wh = window.outerHeight
    // var starAnimation = new PIXI.Application(ww,wh,{antialias: false,transparent: true, resolution: 1})
    // this.$el.querySelector(".bg").appendChild(starAnimation.view);
    // // var reg = new PIXI.Graphics()
    // // reg.lineStyle(1, 0xffffff)
    // //    .moveTo(0, 0)
    // //    .lineTo(ww, wh);
    // // starAnimation.stage.addChild(reg)

    // var Star = function (){
    //   this.position = {
    //     x: Math.random()*ww,
    //     y: Math.random()*wh
    //   }
    //   this.v = {
    //     x: Math.random()*2-1,
    //     y: Math.random()*2-1,
    //     ang: (Math.random()*4-2)/360
    //   }
    //   this.size = Math.random()*70+30
    //   this.alpha = Math.random()*0.15
    //   this.blurseed = Math.random()/10
    //   this.updatePosition = function(){
    //     this.position.x += this.v.x 
    //     this.position.y += this.v.y 
        
    //     if (this.position.x>ww+this.size){
    //       this.position.x=-this.size
          
    //     }
    //     if (this.position.y>wh+this.size){
    //       this.position.y=-this.size
    //     }
    //     if (this.position.x<0-this.size){
    //       this.position.x=ww+this.size
    //     }
    //     if (this.position.y<0-this.size){
    //       this.position.y=wh+this.size
    //     }
    //     this.el.position.x = this.position.x
    //     this.el.position.y = this.position.y
    //     this.el.rotation += this.v.ang
    //     this.el.alpha = this.alpha
        
    //     //blur
    //     // this.el.filters[0].blur=10+4*Math.cos(starAnimation.ticker.lastTime/(500+300*this.blurseed)+this.blurseed)
    //   }
    //   this.el = null
    //   this.init = function(){
    //     let star1 = new PIXI.Graphics()
    //     let size = this.size

    //     var blurFilter1 = new PIXI.filters.BlurFilter();
    //     star1.beginFill(0xFFFFFF);
        
    //     let type = Math.ceil(Math.random()*10)
    //     if (type<6){
    //       star1.drawCircle(0,0,size/2)
    //     }else{
    //       star1.drawRect(-size/2,-size/2,size,size)
    //     }
    //     // }else if (type<6){
    //     //   star1.drawCircle(this.position.x,this.position.y,size/2,size/2)
        
    //     star1.endFill();

    //     blurFilter1.blur=Math.random()*10+2
    //     star1.alpha/=(blurFilter1.blur/2)
    //     star1.filters = [blurFilter1]
    //     // star1.anchor.set(0.5)
    //     this.el = star1
        
    //   }
    // }
    // console.log(Star)
    // var stars = Array.from({length: 40},function(){
    //   var st =  new Star()
    //   console.log(st)
    //   st.init()
    //   starAnimation.stage.addChild(st.el);
    //   return st
    // })

    // starAnimation.ticker.add(function(){
      
    //   let mousePosition = mousePos
    //   stars.forEach((star,index)=>{
    //     star.position.x+= (mousePosition.x-star.position.x)*0.001
    //     star.position.y+= (mousePosition.y-star.position.y)*0.001
    //     star.updatePosition()
        
    //   })
    //   // var mousePosition = starAnimation.renderer.plugins.interaction.mouse.global;
    //   // console.log(mousePosition)
    //   // stars[0].el.position.x=mousePosition.x
    //   // stars[0].el.position.y=mousePosition.y
    // })

  }
}
</script>

<style lang="sass" >
@import '../../assets/sass/_variables.sass'
@import '../../assets/sass/_mixins.sass'
.page_nav
  .user
    position: fixed
    right: 80px
    top: 25px
    color: white
    cursor: pointer
    z-index: 100
  .auth_container
    background-color: rgba($colorBlue,0.8)
    padding: 30px 50px
    position: fixed
    z-index: 500
    box-sizing: border-box
    +flexCenter
    +size(100%)
  .close
    position: absolute  
    +size(100%)
    left: 0
    top: 0
    cursor: pointer

</style>
