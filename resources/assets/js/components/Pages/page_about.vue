<template lang="pug">
  .page.page_about
    section.sectionHero.theme.blue
      //- h1 關於我們
      img.coverGraphic(src="/img/about_sectionAbout_BigD.png")
      
    section.sectionQuestion.theme.blue
      .container
        .row
          .col-sm-12
            //p 在創新創業風氣興盛後，臺大覺察學校創新教育的不足，遂於2014年成立創新設計學院，並於2015年秋季正式授課。<br>為全台大共有的學院—D-School 

      .container.theme.white.card
        .row
          .col-sm-12
            h2 我想了解
            hr
        .row.row-qa(v-for="(qa,qaid) in QAs" )            
          .col-sm-6.col-answer(v-if="qaid%2==1")
            p.answer(v-html="qa.answer")
          .col-sm-6
            .num Q{{qaid+1}}
            h3.question Q{{qaid+1}}: 
              span {{qa.question}}
            
          .col-sm-6.col-answer(v-if="qaid%2==0")
            p.answer(v-html="qa.answer")
        //.row
          .col-sm-6
            p.answer 這門課程將帶領學生重新感覺周圍的各種聲響，從不同的角度學習欣賞與聆聽，體認音樂的多元性與藝術性。透過生活中的觀察體驗，發掘人類對於音樂的需求，針對特定議題，發想音樂可能的使用與表現方式，發揮自己的專長進行音樂與其他領域的創新設計與改造應用。
          .col-sm-6.col-answer
            .num Q2
            h3.question Q2 :
              span  臺大創新學院是在做什麼的啊？

      
    //section.sectionTimeline.theme.blue
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
          .col-sm-3.col-cata(v-for="(memberCata,mid) in memberCata",
                             v-if="nowCata==mid+1 || nowCata==-1")
            span(@click="nowCata = mid+1",)
              h5.eng {{ memberCata.eng }}
              h3.label {{ memberCata.label }}
              h4.type {{ memberCata.type }}
              img.people.wow.slideInBottom( :src="memberCata.img", style="width: 100%")
            .btn.btn-text(v-if="nowCata!=-1", @click="nowCata=-1")
              i.fa.fa-angle-left
              | &lt; 返回總表
        
          .col-sm-9
            .col-sm-3.col-member(
              v-for="member in filtered_teammember")
              .img(:style="cssbg(member.cover)" )
                .cata(v-if="memberCata[member.cata-1]") {{memberCata[member.cata-1].type}}
                router-link.edit_btn(v-if="is_admin", :to="`/manage/member/${member.id}`") 編輯
              h3 {{member.name}} 
              h5 {{member.position}} 
                span(v-if='member.company') ,{{member.company}}

            fullPage(@click="closeFullpage=")
              
</template>

<script>
import {mapState} from "vuex"
import {WOW} from "wowjs"
import fullPage from "./components/fullPage"
   var wow = new WOW()
export default {
  mounted(){
    setTimeout(function(){
      wow.sync()

    },1000)
  },
  data(){
   return {
     QAs: [
       {
         question: "咦？台大創新設計學院是什麼地方啊，平常都在幹嘛呢～？",
         answer: "創新設計學院以創造跨領域合作為目標，邀請不同系所、不同專業的師生來到學院。開設校內學分課程、舉辦工作坊及講座活動等。並設計優質的討論空間及休息室，讓大家在舒適的環境中發揮想像和創意。同時，學院為了鼓勵同學們將想法落實，提倡動手做的精神，我們也建置了「實作中心」！實作中心內設有雷射切割機、3D印表機、CNC等等機械設備。所以～只要你走進學院，就會發現有人在上課、在為了某個理想激烈討論、在放空思索人生、在把玩機械或是模型、或是在吃東西！？總之，我們是一個支持任何可能發生的地方喔！"
       },
       {
         question: "哇！創新設計學院好有趣喔！我可以報考嗎？",
         answer: "不行喔～創新設計學院為台大的一級性功能單位（也就是說，校內組織架構可分為：學術單位、行政單位、功能性中心。我們是屬功能性中心），不是一般理學院工學院，讓你可以唸完四年的學院啦！<br>順帶一提，我們也是臺灣第一個具有實體空間的虛擬學院唷！"
       },
       {
         question: "為什麼台大會建立創新設計學院呢？學院是怎麼運作的呢？",
         answer: "在創新創業風氣興盛後，臺大覺察學校創新教育的不足，在前校長楊泮池教授及前學術副校長陳良基教授等人的堅持與努力，並加入校友王大壯先生的捐贈，遂於2014年3月24日正式成立創新設計學院，並於2015年秋季正式開課。<br>創新設計學院為全台大共有的學院，由校長任命學術副校長為執行長，統籌各院的需求成立跨領域的教學與研究的環境，在執行長之上有由台大的11個學院的院長組成的諮詢委員會，也任命副執行長(現為工學院院長、管理學院院長、社科學院院長)協助管理與規劃，在執行面有負責整體行政事務的行政組，負責課程規劃與執行的教學組，以及負責人文社會議題的人社組。"
       },
       {
         question: "那麼～我要如何參與學院大小事呢？",
         answer: "如果你是～1.台大學生：可以選修學院所開設的學分課程，若是曾修過學院課程的學生，也能優先入取工作坊講座等活動。<br>如果你是～2.台大老師：將自己的研究領域帶入學院課程中，並結合設計思考的方式，創造跨科系領域的課程體驗。<br>如果你是～3.非台大學生：除了學分課程的選修上較不易執行，亦能參加學院的大小活動及實作工作坊。也非常歡迎擔任學院小管家、課程助教、實作中心小老大、學術小組教練等。<br>如果你是～4.非台大老師：可以從參與學院定期舉辦的「21趴跨領域教師交流會」開始，認識學院的老師及夥伴。學院也非常歡迎大家將熱情與專業投入，進一步在學院開設零學分的工作坊等。亦或帶領自己的學生，一同參與「D-Day期末成果展」。"
       },
       {
         question: "我需要具備什麼樣的能力才能參與嗎？",
         answer: "我們希望在跨領域的合作能夠為專案提供更完善的解決方案，同時培養同學們合作與溝通的能力。因此，許多課程會以大三大四同學優先錄取。"
       },
       {
         question: "學院未來的目標是什麼？",
         answer: "台大創新設計學院係在仍只是推動創新教育的起步，希望能全面地影響台灣創造力與創新能力的教育，培養各領域的核心人才，成為台灣重要的設計實踐基地，實踐社會關懷的教育典範。"
       }
     ],
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
     ],
     nowCata: -1
   }
  },
  computed:{
    ...mapState(['user','posts','scrollTop','teammembers']),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    },
    filtered_teammember(){
      return this.teammembers
              .filter(o=>o.cata==this.nowCata || !this.nowCata)
    }
  }
}
</script>

<style>

</style>
