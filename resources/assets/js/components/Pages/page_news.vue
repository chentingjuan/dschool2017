<template lang="pug">
  .page.page_news
    //section.sectionHero.white
      //- h1 實作中心 D-SCHOOL
      //- img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    section.sectionHero.white
      .container
        .col-sm-2
          ul
            li(v-for="cata in catas") {{cata}}
        .col-sm-10
          ul.list-group
            li.list-group-item.col-sm-6(
              v-for="post in posts",
              v-if="post.show" )
              router-link(:to="`/news/${post.title}`")
                img(:src="post.cover", style="width: 100%")
                h3 {{ post.title }}
                p {{ post.description }}

</template>

<script>
import {mapState} from 'vuex'

export default {
  data(){
    return {
      // posts: []  
    }
  },
  computed:{
    ...mapState(['posts']),
    catas (){
      return this.posts.map(o=>o.cata).filter((d,i,arr)=>arr.indexOf(d)==i)
    }
  },
  mounted(){
    // axios.get("/api/post").then((res)=>{
    //   Vue.set(this,"posts",res.data)
      
    // })
  }
}
</script>

<style>

</style>
