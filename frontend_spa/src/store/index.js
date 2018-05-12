import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
const store = new Vuex.Store({
  modules: {
    auth: require("./modules/auth.js").default,
  },
  state: {
    user: window.user,
    csrf_token: window.csrf_token,
    activities: [],
    posts: [],
    teammembers: [],
    QAinfos: [],
    scrollTop: 0,
    loading: document.domain != "dschool2017.test",
  },
  mutations: {
    setLoading(state, value) {
      state.loading = value
    },
    set_user(state, value){
      state.user=value;
    },
    setScrollTop(state,value){
      state.scrollTop=value
    },
    setActivities(state, value) {
      state.activities = value
    },
    setPosts(state, value) {
      state.posts = value
    },
    setTeammembers(state, value) {
      value.forEach(o=>o.cata=parseInt(o.cata))
      state.teammembers = value
    },
    setQAinfos(state, value) {
      state.QAinfos = value
    }
  },
  actions: {
    loadEvents(context){
      axios.get("/api/activity").then(res => {
        context.commit("setActivities", res.data )
      })
    },
    loadWebsite(context){
      context.dispatch("loadEvents")
      context.dispatch("loadPosts")
      context.dispatch("loadTeammembers")
      context.dispatch("loadQAinfos") 
    },
    loadPosts(context){
      axios.get("/api/post").then((res) => {
        context.commit("setPosts", res.data)
      })
    },
    loadQAinfos(context) {
      axios.get("/api/qainfo").then((res) => {
        context.commit("setQAinfos", res.data)
      })
    },
    loadTeammembers(context) {
      axios.get("/api/teammember").then((res) => {
        context.commit("setTeammembers", res.data)
      })
    }
  }
})
export default store