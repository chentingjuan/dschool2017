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
            router-link.btn.btn-primary(
                        v-if="is_admin", 
                        :to="'/manage/post/new'",
                        style="color: white") 新增新聞
            router-link.btn.btn-primary(
                        v-if="is_admin", 
                        :to="'/manage/post'",
                        style="color: white") 管理條列清單
        .row
          ul.col-sm-4( v-for="chunk in chunkedList")
            li(v-for="post in chunk",
              v-if="post.show || is_admin",
              :style="{opacity: (!post.show && is_admin)?0.6:1}" )
              router-link.news_box(:to="`/news/${post.title}`")
                img(:src="post.cover", style="width: 100%")
                .infos
                  h4.date {{ post.date }}
                  h3.title {{ post.title }} {{ ((!post.show && is_admin)?"(草稿)":"" ) }}
                  p.content {{ post.description }}
                  router-link.btn.btn-primary.form-control(
                    v-if="is_admin", 
                    :to="'/manage/post/'+post.id",
                    style="color: white") 編輯
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
    ...mapState(['user','posts']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    },
    catas (){
      return this.posts.map(o=>o.cata).filter((d,i,arr)=>arr.indexOf(d)==i)
    },
    chunkedList(){
      let result = [[],[],[]]
      this.posts.slice().reverse().forEach((d,i)=>{
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
