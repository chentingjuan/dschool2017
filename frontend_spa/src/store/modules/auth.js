import axios from 'axios';
import schoolData from '../../dataSchools'

const moduleAuth = {
  namespaced: true,
  state: {
    token: localStorage.dschool_auth_user_token || null,
    user: null,
    processing: false,
    status: "",
    domain: "/api/auth",
    jobcatas: schoolData
  },
  mutations: {
    setUserToken(state, value) {
      state.token = value
      localStorage.setItem("dschool_auth_user_token", state.token);
    },
    setUser(state, value) {
      state.user = value
      if (state.user) {
        localStorage.setItem("dschool_auth_user_email", state.user.email);

      }
    },
    setStatus(state, value) {
      state.status = value
      setTimeout(() => {
        state.status = ""
      }, 3000);
    },
    setProcessing(state, value) {
      state.processing = value
    }
  },
  actions: {
    init(context) {
      if (context.state.token) {
        context.commit("setProcessing", true)
        context.dispatch("getUser")
      }
    },
    register(context, user) {
      context.commit("setProcessing", true)
      axios.post(context.state.domain + "/register", user).then((res) => {

        // console.log(res.data)
        context.commit("setUserToken", res.data)
        context.dispatch("getUser")

        if (res.data.status == "fail") {
          console.log(res)
          context.commit("setProcessing", false)
          context.commit("setStatus", "註冊失敗.." + res.data.error)

        }
      }).catch((res) => {
        console.log(res)
        context.commit("setProcessing", false)
        context.commit("setStatus", "註冊失敗..")

        return {
          success: false,
          log: res.data
        }
      })
    },
    login(context, user) {
      
      return new Promise((resolve,reject)=>{
        context.commit("setProcessing", true)
        axios.post(context.state.domain + "/login", user).then((res) => {
          context.commit("setStatus", "登入成功..")
          context.commit("setUserToken", res.data.access_token)
          context.dispatch("getUser")
          resolve("login success")
        }).catch(res => {
          context.commit("setProcessing", false)
          context.commit("setStatus", "登入失敗..")
          reject("login fail")

        })
      })
    },
    getUser(context) {
      axios.post(context.state.domain + "/me", {
        token: context.state.token
      }).then((res) => {
        context.commit("setUser", res.data)
        context.commit("setProcessing", false)
      }).catch((res) => {
        context.commit("setUserToken", "")
        context.commit("setProcessing", false)
      })
    },
    logout(context) {
      context.commit("setProcessing", true)
      axios.post(context.state.domain + "/logout", {
        token: context.state.token
      }).then((res) => {
        if (res.data.status == "success") {
          context.commit("setUser", null)
          context.commit("setUserToken", null)
          context.commit("setStatus", res.data.message)
          context.commit("setProcessing", false)

        }
      })
    },
    loginFacebook(context) {
      window.open(context.state.domain + "/login/facebook")
    },
  },
  getters: {
    getUserPhoto: state => {
      if (state.user) {
        return state.user.cover
      } else {
        return "/static/img/Home/za-logo.svg"

      }

    },
    canManage: state => {
      console.log(state.user)
      if (state.user) {
        return state.user.admingroup == "root" || state.user.admingroup == "editor";
      }
      return false
    },
    isAdmin: state => {
      if (state.user) {
        return state.user.admingroup == "root" ;
      }
      return false
    },
    userGroup: state => {
      if (state.user) {
        return state.user.admingroup
      }
      return null
    }


  }
}

export default moduleAuth