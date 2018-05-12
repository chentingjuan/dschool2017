<template lang="jade">
  .svg_inline(v-html="scoped_html",
              :class="'svgi_'+hash")
</template>


<script>
import axios from 'axios'
  export default {
    props: ["src"],
    data(){
      return {
        svg_html: "",
        hash: parseInt(Math.random()*1000000000)
      }
    },
    mounted(){
      axios.get(this.src).then((r)=>{
        console.log(r)
        this.svg_html=r.data
      })
    },
    computed:{
      scoped_html(){
        return this.svg_html.replace(/cls/g,"svgi_"+this.hash+"_cls_")
      }
    }
  }
</script>

<style>
  
</style>