<template lang="pug">
  .page.page_question
    section.sectionHero.theme.blue
      //- h1 常見問題
      img.coverGraphic(src="/img/hero_qa_cover.svg")
    section.sectionIntro
      .container
        .row
          .col-sm-11.col-sm-offset-1.col-md-10.col-md-offset-2.col-lg-10.col-lg-offset-2(v-for="(question,qid) in questions",
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
    ...mapState(['questions'])
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
