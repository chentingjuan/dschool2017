<template lang="pug">
.auth-card
  transition(name="fade")
    div(v-if="layout=='card'")
      transition(name="fade")
        .card-loading(v-if="auth.processing")
      .top
        //.photo(:style="bgcss(getUserPhoto(auth.user))")
        img.logo(src="/static/img/index__pageLogoOrange.svg")
        h3.name
          span(v-if="auth.user") {{ auth.status ||  `Dschool 學生　${auth.user.name}` }}
          span(v-else) {{ auth.status || '您尚未登入哦！' }}
      .bottom(v-if="mode=='login' && !auth.user")
        h4.login-title 登入Dschool
        //- label 信箱
        input(v-model="loginData.email", placeholder="信箱", type="email")
        //- label 密碼
        input.loginPwd(v-model="loginData.password", placeholder="密碼" , type="password")
        .row.mt-5
          
          button.btn.fw.nobg(@click="mode='reset_send_email'") 忘記密碼
          button.btn.lightGrey(@click="panelLogin") 登入
          button.btn.lightGrey(@click="mode='register'") 註冊
        //button.btn.fw.nobg 忘記密碼

        
      .bottom(v-if="mode=='register' && !auth.user")
        h4 會員註冊
        //- label email
        div.select-type
          span(@click="registType='student'",
              :style="{opacity: registType=='student'?1:0.4 }") 我是學生
          span &nbsp;|&nbsp;
          span(@click="registType='work'",
              :style="{opacity: registType=='work'?1:0.4 }") 我是社會人士
        el-form
          el-form-item
                
            el-input(v-model="registerData.name" placeholder="姓名")
            el-input(v-model="registerData.email", 
                    placeholder="Email", 
                    type="email", name="email", autocomplete="on")
            el-input(v-model="registerData.phone" placeholder="電話")
        //- label name
        div.form-student(v-if="registType=='student'")
          el-select(v-model="registerData.dschool", 
                    placeholder="學校與學院" , name="dschool", 
                    autocomplete="on", style="width: 100%")
            el-option(v-for= "(jb,jbid) in auth.jobcatas", 
                  :value="jb", :label="jb") {{jb}}
          el-input(v-model="registerData.department", placeholder="系級")
          el-input(v-model="registerData.student_id", placeholder="學號")

        div.form-work(v-if="registType=='work'")
          el-input(v-model="registerData.agency", placeholder="服務單位")
          //- el-input(v-model="registerData.job", :placeholder="jobInforLabel", type="job", name="job", autocomplete="on")
        el-input(v-model="registerData.password", placeholder="密碼", type="password")
        el-input(v-model="registerData.confirmpassword", placeholder="確認密碼", type="password")


        div.form-social
        button.btn.fw.nobg(@click="mode='reset_send_email'") 忘記密碼
        button.btn.fw.black(@click="register(registerData)") 註冊
        //- label(v-if="auth.status") {{auth.status}}
        button.btn.fw.nobg(@click="mode='login'") 我已經有帳號了！ 前往登入

      
      .bottom(v-if="auth.user")
        //h4 學生簡介
        div.mt-3
          .info-group
            label
              span 帳號類型
            span {{ auth.user.type=='student'?'學生':'社會人士' }}
          .info-group
            label
              span 信箱
            span {{ auth.user.email }}
          .info-group
            label
              span {{ auth.user.type=='student'?'學校':'公司' }} 
            span {{ auth.user.school || auth.user.company }} 
          .info-group(v-if="auth.user.type=='student'")
            label
              span 系級 
            span {{ auth.user.department }}

          .info-group(v-if="auth.user.type=='student'")
            label
              span 學號 
            span {{ auth.user.student_id }}
        div
          label.info-group

        br
      
        div
          .btn.fw.lightGrey.text-black(@click="logout") 登出
          span(@click="$emit('onClose')")
            router-link.btn.fw.lightGrey.text-black(to="/my/activity") 我的活動
          span(@click="$emit('onClose')")
            router-link.btn.fw.orange(to="/manage") 前往後台

      .bottom(v-if="mode=='reset_send_email' || forceMode=='reset'")
        h4 重設密碼
        div(v-if="!auth.password_reset_success")
          el-input(placeholder="輸入原帳號信箱", type="email", name="email", v-model="resetSendMailData.email")
          button.btn.lightGrey(@click="resetSendMail(resetSendMailData)" @keydown.enter.prevent="resetSendMail(resetSendMailData)")  寄出重設密碼連結
        div(v-else)
          h5 已寄出密碼重設連結，請前往信箱收信確認！

      .bottom(v-else-if="mode=='reset_password'")
        h4 重設使用者密碼
        el-input(placeholder="輸入原帳號信箱", type="email", name="email", v-model="resetPasswordData.email")
        el-input(placeholder="請輸入新密碼", type="password", name="password", v-model="resetPasswordData.password")
        el-input(placeholder="再次輸入密碼", type="password", name="password_confirmation", v-model="resetPasswordData.password_confirmation")
        button.btn.lightGrey(@click="userResetPassword" ) 重設

    div(v-if="layout=='function'")
      .btn-group
        button.btn.lightGrey(@click="logout") 登出
      .btn-group(v-if="canManage")
        router-link.btn.fw.black(to="/manage") 前往後台
      //pre {{auth}}



</template>

<script>
import {mapState,mapMutations, mapActions, mapGetters} from 'vuex'
import $ from 'jquery'
export default {
  props: {
    layout: {
      type: String,
      default: "card",
    },
    forceMode: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      registerData: {
      },
      registType: "student",
      loginData: {
        email:  localStorage.dschool_auth_user_email || "",
        password: "",
        
      },
      resetSendMailData:{
        email: "",
      },
      resetPasswordData:{
        email: localStorage.dschool_reset_user_email || "",
        password: "",
        password_confirmation: "",
        token: ""
      },
      mode: window.queryObject.reset_token?"reset_password":"login",
    }
  },
  computed: {
    ...mapState(['menuState','auth']),
    jobInforLabel(){
      if (this.registerData.jobcata=="學生"){
        return "學校系所"
      }
      return "職稱"
    },

    ...mapGetters({
      getUserPhoto: 'auth/getUserPhoto',
      isAdmin: 'auth/isAdmin',
      isEditor: 'auth/isEditor',
      canManage: 'auth/canManage',
      userGroup: 'auth/userGroup'
    }),

  },
  methods: {
    ...mapMutations({
      setMenuState: "setMenuState",
      setResetToken: "auth/setResetToken"
    }),
    ...mapActions({
      register: 'auth/register',
      login: 'auth/login',
      logout: 'auth/logout',
      loginFacebook: "auth/loginFacebook",
      authInit: "auth/init",
      resetSendMail: "auth/resetSendMail",
      resetPassword: "auth/resetPassword"
    }),
    panelLogin(){
      this.login(this.loginData).then(()=>{
        this.$emit("onLogin")

      })
    },

    userResetPassword(){
      let _this = this
      this.resetPassword({
        data: this.resetPasswordData,
        successHook: ()=>{
          this.$message.success( "密碼重設成功！" )

          setTimeout(()=>{
            _this.setResetToken(null)
            _this.mode="login"
            //- window.location.href=window.location.href.split("?")[0]
            // this.$router.push("/")
            // this.setMenuState(false)
          },1500)
          
        },
        failHook: ()=>{
          this.$message.error( "密碼重設失敗..." )
        }
      })
    },
  },
  mounted(){
    // this.authInit()
    $("input.loginPwd").keypress((ev)=> {
          var keycode = (ev.keyCode ? ev.keyCode : ev.which);
          if (keycode == '13') {
            this.login(this.loginData)
          }
      })
  }
}
</script>

<style lang="sass" >

.auth-card
  text-align: center
  display: flex
  justify-content: center
  width: 100%
  box-sizing: border-box
  flex-direction: column
  max-width: 500px
  position: relative
  // margin: 20px
  
  // position: fixed
  // left: 50%
  // top: 50%
  // transform: translate(-50%,-50%)
  // z-index: 100
  
  box-shadow: 0px 0px 40px rgba(black,0.3)

  .select-type
    span
      cursor: pointer
      padding: 5px 10px
  .logo
    max-width: 60px

  h4.login-title
    margin-top: -20px
    margin-bottom: 30px
  label.mention
    font-size: 13px
    opacity: 0.5
  input,select
    border: none
    outline: none
    width: 100%
    background-color: transparent
    padding: 5px 10px
    border-bottom: solid 1px rgba(#131116,0.2)
    margin-bottom: 10px
    font-size: 14px
  .card-loading
    position: absolute
    width: 100%
    height: 100%
    background-color: rgba(#eee,0.6)
    // opacity: 0.5
    left: 0
    top: 0

  .top
    display: flex
    justify-content: center
    flex-direction: column
    align-items: center
    // margin-bottom: 3px
    background-color: white
    padding: 50px
    padding-bottom: 0
    .name
      font-size: 18px
  .bottom
    background-color: white
    padding: 25px
    padding-left: 30px
    padding-right: 30px
    display: flex
    justify-content: center
    align-items: center
    flex-direction: column
    .info-group
      display: flex
      max-width: 350px
      justify-content: space-between
      label
        width: 100px
        opacity: 0.9
        font-weight: 500
        text-align-last: left
      span
        flex: 1
        text-align: left
  .photo
    width: 136px
    height: 136px
    overflow: hidden
    margin-top: 55px
    margin-bottom: 40px
    // background-color: black
    background-position: center center
    background-repeat: no-repeat
    background-size: 100% auto



</style>
