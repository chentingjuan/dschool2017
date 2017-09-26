<template lang="pug">
  div
    Navbar
    transition(name="fade" mode="out-in")
      router-view(:key="$route.path")
   
    //- section_footer
</template>


<script>
import Navbar from './Navbar'
export default {
  components: {
    Navbar
  }
}
</script>

<style lang="sass?indentedSyntax">
  


</style>

