<template lang="pug">
  .page.page_post
    //section.sectionHero.white
      //- h1 實作中心 D-SCHOOL
      //- img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    section.sectionHero.white
      .container
        .row.row-card
          .col-sm-7.col-cover(:style="`background-image:url(${post.cover})`")
            //- img(style="width: 100%")
          .col-sm-5.col-info
            h3 {{ post.cata }}
            hr
            h2 {{ post.title }}
            h4.date {{ post.date }}
            p {{ post.description }}

    section.sectionContent.white
      .container
        .col-sm-7.col-cover
        p(v-html="trans(post.content)")
    section.sectionMore.blue
      .container-fluid
        .row
          .col-sm-6.col-rpost
            router-link.rpost(
                v-if="navPost.pre", 
                :style="`background-image:url(${navPost.pre.cover})`", 
                :to="'/news/'+navPost.pre.title")
              h4.cata {{navPost.pre.cata}}
              br
              h3.title {{navPost.pre.title}}
          .col-sm-6.col-rpost
            router-link.rpost(
                v-if="navPost.post", 
                :style="`background-image:url(${navPost.post.cover})`", 
                :to="'/news/'+navPost.post.title")
              h4.cata {{navPost.post.cata}}
              br
              h3.title {{navPost.post.title}}


</template>

<script>
import {mapState} from "vuex"
export default {
  props: [
    "title"
  ],
  data(){
    return {
      
    }
  },
  mounted(){
    
  },
  computed: {
    ...mapState(["posts"]),
    post(){
      return this.posts.find(o=>o.title==this.title)
    },
    navPost(){
      let nowIndex = -2
      this.posts.forEach( (p,pid)=>{
        if (p.id==this.post.id){
          nowIndex = pid
        }
      })
      let pre = this.posts[nowIndex-1]
      let post = this.posts[nowIndex+1]

      return {
        pre , post
      }
    }
  },
  methods: {
    trans(content){
      let result =  content.replace(/\/assets\/image\//g,"http://dschool.ntu.edu.tw/assets/image/")
      result = result.replace(/\<img.*?src=\"(.*?)\".*?\>/,"<img src='$1'>")
      //result = result.replace(/\<img.*?src=\"(.*?)\".*?\>/,"<div class='contentImage' style='background:url($1)'></div>")
      return result
    }
  }
}
</script>

<style>

</style>