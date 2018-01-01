<template lang="pug">
  .page.page_news
    section.sectionHero.theme.blue
      //- img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    section.sectionHero.blue
      .container
        //.col-sm-2
          ul
            li(v-for="cata in catas") {{cata}}
        .row
          .col-sm-12
            router-link.btn.orange(
                        v-if="is_admin", 
                        :to="'/manage/post/new'") 新增新聞
            router-link.btn.white(
                        v-if="is_admin", 
                        :to="'/manage/post'") 管理條列清單
          br
          br
          br
        .row
          .col-sm-12
            router-link.news_box.animated.fadeIn(:to="`/news/${spotPost.title}`").row
              .img(:style="cssbg(spotPost.cover)").col-sm-8
              .col-sm-4
                .infos
                  h4.spottext 焦點消息
                  hr
                  h4.date {{ spotPost.date }}
                  h2.title {{ spotPost.title }} {{ ((!spotPost.show && is_admin)?"(草稿)":"" ) }}
                  p.content {{ strip_tags(spotPost.description || spotPost.content).slice(0,200) }}
                router-link.btn.btn-primary.btn-edit(
                  v-if="is_admin", 
                  :to="'/manage/post/'+spotPost.id") 編輯
    section.sectionNews
      .container
        .row
          ul.col-sm-4( v-for="chunk in chunkedList")
            li(v-for="post in chunk",
              v-if="post.show || is_admin",
              :style="{opacity: (!post.show && is_admin)?0.6:1}",
              :key="post.title+post.id" )
              router-link.news_box.animated.fadeIn(:to="`/news/${post.title}`")
                .img.col-sm-12(:style="cssbg(post.cover)")
                .infos.col-sm-12
                  h4.date {{ post.date }}
                  h3.title {{ post.title }} {{ ((!post.show && is_admin)?"(草稿)":"" ) }}
                  p.content {{ strip_tags(post.description || post.content).slice(0,200) }}
                router-link.btn.btn-primary.btn-edit(
                  v-if="is_admin", 
                  :to="'/manage/post/'+post.id") 編輯
            li.endbar
      
</template>

<script>
import _ from 'lodash'
import {mapState} from 'vuex'

export default {
  data(){
    return {
      // posts: []  
      limit: 10
    }
  },
  computed:{
    ...mapState(['user','posts','scrollTop']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    },
    catas (){
      return this.posts.map(o=>o.cata).filter((d,i,arr)=>arr.indexOf(d)==i)
    },
    chunkedList(){
      let useList = this.posts.slice().reverse().slice(0,this.limit)
      let result = [
                    useList.filter((d,i)=>i%3==0),
                    useList.filter((d,i)=>i%3==1),
                    useList.filter((d,i)=>i%3==2)
                  ]
      return result
    },
    spotPost(){
      return this.posts
              .slice().reverse().filter(o=>o.show)[0]
    }
  },
  watch:{
    scrollTop(){
      if (this.scrollTop+$(window).height()*1.5>$(".endbar").offset().top){
        this.limit+=9
      }
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
