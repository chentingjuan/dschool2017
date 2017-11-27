import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
const store = new Vuex.Store({
  state: {
    user: window.user,
    csrf_token: window.csrf_token,
    activities: [],
    posts: [],
    scrollTop: 0
  },
  mutations: {
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
    },
    loadPosts(context){
      axios.get("/api/post").then((res) => {
        context.commit("setPosts", res.data)
      })
    }
  }
})
export default store