<template lang="pug">
  .page.page_question
    section.sectionHero.theme.blue
      //- h1 常見問題
      img.coverGraphic(src="/img/hero_qa_cover.svg")
    section.sectionIntro
      .container
        .row
          .col-sm-12
            router-link.btn.btn-primary(v-if="is_admin",
              to="/manage/question") + 管理問題
        .row
          .col-sm-12(v-for="(question,qid) in questions",
                     :class="'q'+qid").theme.white.card.hover
            h2 {{question.title}}
            p(v-html="question.content")
            br
      .anchors
        ul
          li(v-for="(question,qid) in questions",
             @click="scrollTo('.q'+qid,{pan:-80})") {{question.title}}



</template>

<script>
import {mapState} from 'vuex'
export default {
  data(){
    return {

    }
  },
  computed: {
    ...mapState(['user','questions']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    },
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
