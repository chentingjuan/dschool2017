<template lang="pug">
  .page.page_news
    //section.sectionHero.white
      //- h1 實作中心 D-SCHOOL
      //- img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    section.sectionHero.blue
      .container
        //.col-sm-2
          ul
            li(v-for="cata in catas") {{cata}}
        .row
          .col-sm-12
            .row
              ul.col-sm-4( v-for="chunk in chunkedList")
                li(v-for="post in chunk",
                  v-if="post.show" )
                  router-link.news_box(:to="`/news/${post.title}`")
                    img(:src="post.cover", style="width: 100%")
                    .infos
                      h4.date {{ post.date }}
                      h3.title {{ post.title }}
                      p.content {{ post.description }}
</template>

<script>
import _ from 'lodash'
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
    },
    chunkedList(){
      let result = [[],[],[]]
      this.posts.forEach((d,i)=>{
        result[i%3].push(d)
      })
      return result
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
