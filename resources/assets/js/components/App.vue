<template lang="pug">
  div
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
  }
}
</script>

<style lang="sass?indentedSyntax">
.page_area
  margin-top: 80px


</style>

