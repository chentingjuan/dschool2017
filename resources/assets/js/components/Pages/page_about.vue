<template lang="pug">
  .page.page_about
    section.sectionHero.blue
      //- h1 關於我們
      img.coverGraphic(src="/img/about_sectionAbout_BigD.png")
    section.sectionQuestion.theme.blue
      .container.theme.white.card
        .row
          .col-sm-12
            h2 我想了解
            hr
        .row
          .col-sm-6
            .num Q1
            h3.question Q1 : 
              span 臺大創新學院是在做什麼的啊？
            
          .col-sm-6.col-answer
            p.answer 這門課程將帶領學生重新感覺周圍的各種聲響，從不同的角度學習欣賞與聆聽，體認音樂的多元性與藝術性。透過生活中的觀察體驗，發掘人類對於音樂的需求，針對特定議題，發想音樂可能的使用與表現方式，發揮自己的專長進行音樂與其他領域的創新設計與改造應用。
        .row
          .col-sm-6
            p.answer 這門課程將帶領學生重新感覺周圍的各種聲響，從不同的角度學習欣賞與聆聽，體認音樂的多元性與藝術性。透過生活中的觀察體驗，發掘人類對於音樂的需求，針對特定議題，發想音樂可能的使用與表現方式，發揮自己的專長進行音樂與其他領域的創新設計與改造應用。
          .col-sm-6.col-answer
            .num Q2
            h3.question Q2 :
              span  臺大創新學院是在做什麼的啊？

      
    section.sectionTimeline.theme.blue
      .container
        .row
          .col-sm-12
            h3.eng Annual Timeline
            h2 學院年表
            hr
        .row
          .col-sm-4
            h3 9月
            h4 上學期開學
            h4 課程說明會/選課
          .col-sm-4
            h3 10月
            h4 21％跨領域教師交流會
            h4 實作中心工作坊
          .col-sm-4
            h3 11月
            h4 大型講座活動
            h4 實作中心工作坊
            
      
    section.sectionMember.theme.white
      .container
        .row
          .col-sm-12
            h2 成員介紹
            hr
        .row
          .col-sm-3.col-cata(v-for="memberCata in memberCata")
            h5.eng {{ memberCata.eng }}
            h3.label {{ memberCata.label }}
            h4.type {{ memberCata.type }}
            img.people( :src="memberCata.img", style="width: 100%")
            .btn 查看更多


</template>

<script>
export default {
  data(){
   return {
     memberCata:[
       {
         eng: "NIN_JA",
         label: "忍者",
         type: "行政團隊",
         img: "/img/about_sectionMembers_staffIcon1.svg"
       },{
         eng: "SEI_FU",
         label: "師傅!",
         type: "教學團隊",
         img: "/img/about_sectionMembers_staffIcon2.svg"
       },{
         eng: "NIN_JA",
         label: "徒弟~",
         type: "學生團隊",
         img: "/img/about_sectionMembers_staffIcon3.svg"
       },{
         eng: "SEI_SHUNG",
         label: "師兄",
         type: "歷屆夥伴",
         img: "/img/about_sectionMembers_staffIcon4.svg"
       }
     ]
   }
  }
}
</script>

<style>

</style>
