import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
const store = new Vuex.Store({
  state: {
    user: window.user,
    csrf_token: window.csrf_token
  },
  mutations: {
    set_user(state, value){
      state.user=value;
    },
    setScrollTop(state,value){
      state.scrollTop=value
    }
  },
  actions: {

  }
})
export default store