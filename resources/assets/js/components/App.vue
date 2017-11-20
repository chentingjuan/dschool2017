<template lang="pug">
div(:class="app_class")
  Navbar
  .page_area
  transition(name="fade" mode="out-in")
    router-view(:key="$route.path")
   
    //- section_footer
</template>


<script>
import Navbar from './Navbar'
export default {
  components: {
    Navbar
  },
  computed: {
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
