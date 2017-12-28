<template lang="pug">
div(:class="app_class")
  transition(name="fade")
    page_loading(v-if="loading")
  Navbar
  .page_area
  transition(name="fade" mode="out-in")
    router-view(:key="$route.path")
  Footer
    //- section_footer
</template>


<script>
import Navbar from './Navbar'
import Footer from './Footer'
import page_loading from './pages/page_loading'
import {mapState,mapMutations} from 'vuex'
export default {
  components: {
    Navbar,Footer,page_loading
  },
  computed: {
    ...mapState(['loading']),
    app_class(){
      let result =  ['route'+this.$route.path.replace(/\//g,'_')]
      if (this.loading){
        result.push("loading")
      }
      return result
    },
  }
}
</script>
