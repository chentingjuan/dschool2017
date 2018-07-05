<template lang="pug">
  .page.page_question
    section.sectionHero.theme.blue
      //- h1 常見問題
      img.coverGraphic(src="/static/img/hero_qa_cover.svg")
    section.sectionQuestions
      .container
        .row
          .col-sm-3
            router-link.btn.btn-primary(v-if="is_admin",
              to="/manage/question") + 管理問題

        .row
          .col-sm-12(v-for="(question,qid) in QAinfos",
                     :class="'q'+qid",
                     @click="toggleQuestion(qid)").theme.white.card.hover
            h3 {{question.title}}
            p(v-html="question.content", 
              :class="{hide: !status[qid]}",
              @click.prevent.stop="clickNo")
            br
      .anchors
        ul
          li(v-for="(question,qid) in QAinfos",
             @click="scrollQuestion(qid)") {{question.title}}



</template>

<script>
import {mapState} from 'vuex'
import Vue from 'vue'
export default {
  data(){
    return {
      status: Array.from({length: 100},(v,i)=>false)
    }
  },
  computed: {
    ...mapState(['user','QAinfos']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    },
  },
  methods: {
    toggleQuestion(qid,value){
      let nv = value!=undefined?value:!this.status[qid]
      Vue.set(this.status,qid, nv)
    },
    clickNo(){

    },
    scrollQuestion(qid){
      this.toggleQuestion(qid,true)
      this.scrollTo('.q'+qid,{pan:-80})
    }
  }
}

// var result = Array.from(document.querySelectorAll(".panel")).map(o=>{
//    var title = o.querySelector("[data-toggle='collapse']")
   
//    var content = o.querySelector(".panel-body")
//     return {title:title.innerHTML.trim().split("</i>")[1],content:content.innerHTML.trim()}

// })

</script>

<style>

</style>
