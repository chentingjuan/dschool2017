<template lang="pug">
  .page.page_post
    //section.sectionHero.white
      //- h1 實作中心 D-SCHOOL
      //- img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    section.sectionHero.white
      .container
        .row.row-card
          .col-sm-7.col-cover(:style="cssbg(post.cover)")
            //- img(style="width: 100%")
          .col-sm-5.col-info
            h3 {{ post.cata }}
            hr
            h2 {{ post.title }}
            h4.date {{ post.date }}
            p(v-html="strip_tags(post.description || post.content).slice(0,200)")

    section.sectionContent.white
      .cross
      .cross
      .container
        //.col-sm-7.col-cover
        p(v-html="trans(post.content)")
        
    section.sectionMore.blue
      .container-fluid
        .row
          .col-sm-6.col-rpost
            router-link.rpost(
                v-if="navPost.pre", 
                :style="cssbg(navPost.pre.cover)", 
                :to="'/news/'+navPost.pre.title")
              h4.cata {{navPost.pre.cata}}
              br
              h3.title {{navPost.pre.title}}
          .col-sm-6.col-rpost
            router-link.rpost(
                v-if="navPost.post", 
                :style="cssbg(navPost.post.cover)", 
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
      let result =  (content || "").replace(/\/assets\/image\//g,"/dschool_old_assets/")
      result = result.replace(/\<img.*?src=\"(.*?)\".*?\>/,"<img src='$1'>")
                    .replace(/(\<iframe.*?http.*?\"\><\/iframe>)/g,"<div class='video-wrapper'>$1</div>")
      //result = result.replace(/\<img.*?src=\"(.*?)\".*?\>/,"<div class='contentImage' style='background:url($1)'></div>")
      return result
    }
  }
}
</script>

<style lang="sass">
.page_post
  .video-wrapper
    width: 100%
    position: relative
    padding-bottom: 56.25%
    margin-top: 30px
    margin-bottom: 30px
    &+blockquote
      margin-top: -35px
      margin-bottom: 42px
      line-height: 2
    // padding-right: 15px
  iframe
    position: absolute
    width: 100%
    height: 100%
</style>