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
@import "../assets/sass/_mixins.sass"
@import "../assets/sass/_variables.sass" 

.fullpage
  position: fixed
  width: 100%
  height: 100%
  left: 0
  top: 0
  opacity: 1
  background-color: rgba($colorBlue,0.9)
  z-index: 2000
  overflow-y: auto
  padding: 20px
  padding-top: 60px

  &>*
    animation-delay: 0.3s
  .front
    position: relative
  .closebg
    position: absolute
    z-index: -1
    +size(100%)
    left: 0
    top: 0
  
  .cross
    color: white
    cursor: pointer
    transform: scale(1.1)
    font-size: 40px
    position: absolute
    right: 20px
    top: 20px
    +rwd_sm
      font-size: 24px
    +trans
    &:hover
      color: $colorRed

    
.fadefullpage-enter-active,.fadefullpage-leave-active
  transition: 0.5s
.fadefullpage-enter,.fadefullpage-leave-to
  opacity: 0
.fadefullpage-enter-to
  opacity: 1

</style>