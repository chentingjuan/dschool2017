<template lang="pug">
div
  transition(name="fadefullpage")
    .fullpage(v-if="show")
      slot.front
      .closebg(@click="closeFullpage")
      .cross(@click="closeFullpage")
        i.fa.fa-times
</template>

<script>
import $ from 'jquery'
export default {
  props: ["show"],
  methods: {
    closeFullpage(){
      this.$emit("closeFullpage")
    }
  },
  mounted(){
    window.addEventListener("keydown",function(evt){
      // console.log(evt.key)
      if (evt.key=="Escape"){
        this.closeFullpage()
      }
    })
  }
}
</script>

<style lang="sass">


</style>
