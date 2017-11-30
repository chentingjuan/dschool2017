<template lang="pug">
  div.page_post_register(v-if="post")
    .container
      .row
        .col-sm-12
          br
          br
          br
          ol.breadcrumb
            li.breadcrumb-item 
              router-link(to="/news") 新聞管理
            li.breadcrumb-item.active 新聞編輯
          h2(v-if="post" ) 編輯- {{ strip_tags(post.title) }}
            
            button.btn.btn-danger.pull-right(@click="deletePost") Delete
            button.btn.btn-primary.pull-right(@click="updatePost") Save
          h2(v-else) 新文章 - {{ strip_tags(post.title) }}
            button.btn.btn-primary.pull-right(@click="updatePost") Save
          hr

        .col-sm-4
          .panel.panel-primary
            .panel-heading Basic Infos
            .panel-body
              //.form-group
                labal.col-sm-3 Type
                .col-sm-9
                  select.form-control(v-if="post"  v-model="post.type")
                    option(v-for="op in activityTypeOptions", :value="op.value") {{op.tag}}
                br
                br
              .form-group
                labal.col-sm-3 Title
                .col-sm-9
                  input.form-control(v-if="post" v-model="post.title")
                br
                br
              .form-group
                labal.col-sm-3 Date
                .col-sm-9
                  input.form-control(v-if="post" v-model="post.date")
                br
                br
              .form-group
                labal.col-sm-3 Cata
                .col-sm-9
                  input.form-control(v-model="post.cata")
                br
                br
              .form-group
                labal.col-sm-3 Tag
                .col-sm-9
                  //- input.form-control(v-model="post.tag")
                  .form-inline
                    input.form-control(v-model="newTag")
                    .btn.btn-primary(@click="post.tag.push(newTag);newTag=''") + 
                  .btn.btn-default(v-for="(tag,tagid) in post.tag") {{tag}}
                    span(@click="post.tag.splice(tagid,1)") &nbsp;-
                  
                br
                br
                br
              
              .form-group
                labal.col-sm-3 Cover
                .col-sm-9
                  input.form-control(v-model="post.cover")
                  img(:src="post.cover", style="width: 100%")
                  default_pic_selector(@select_pic="select_pic_cover")
                br
                br

              .form-group
                labal.col-sm-3 Sticktop
                .col-sm-9
                  input.form-control(type="checkbox" v-model="post.stick")
                br
                br

        .col-sm-8
          .panel.panel-default
            .panel-heading Content
            .panel-body
              .form-group
                .col-sm-12
                  VueEditor.ve(:id ="'content'", v-model="post.content" ,
                    :useCustomImageHandler="true",
                    @imageAdded="handleImageAdded" )
                  br
                  br
              //.form-group
                labal.col-sm-3 註冊資訊
                .col-sm-9
                  VueEditor.ve(:id ="'register_info'", v-model="post.register_info")
                  br
                  br
          
          </template>

</template>

<script>
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
import Axios from 'axios'
import default_pic_selector from '../default_pic_selector.vue'
//import ActivityInfoRow from './ActivityInfoRow'
import _ from 'lodash'
export default {
  props: ["post_id"],
  data(){
    return {
      order: true,
      post: {

      }
    }
  },
  mounted() {
      console.log('Component mounted.')
      var a = this.nowpost
  },
  computed:{
    ...mapState(['user','activities','posts']),
    nowpost(){
      let result = this.posts.find(o=>o.id==this.post_id)
      if (result ){
        this.post = result
      }
      return result
    }
  },
  components:{
    VueEditor,default_pic_selector
  },
  methods: {
    setPost(post){
      // post.tag = JSON.parse(post.tag)
      // post.speaker = JSON.parse(post.speaker)
      // if (!post.album){
      //   post.album=Array.from({length: 4},()=>({image: "",caption: ""}))
      // }else{
      //   post.album = JSON.parse(post.album)
      // }
      // // console.log(post.album)
      this.post = post
    },
    deletePost(){
      if (confirm("Are you sure to delete post?")){
        Axios.post("/api/post/"+this.post_id,{
          _method: "DELETE"
        }).then((res)=>{
          alert("Delete Success!")
        })
      }

    },
    select_pic_cover(obj){
      this.post.cover = obj.url
    },
    updatePost(){
      if (this.$route.path=="/manage/post/new"){
        Axios.post("/api/post",{
          _method: "POST",
          ...this.post
          
        }).then((res)=>{
          this.setPost(res.data)
          alert("Create Success!")
        })
      }else{
        Axios.post("/api/post/"+this.post_id,{
          _method: "PATCH",
          ...this.post
          
        }).then((res)=>{
          this.setPost(res.data)
          alert("Save Success!")
        })
      }
      

    }
  }
}

</script>


<style lang="sass?indentedSyntax">
</style>
