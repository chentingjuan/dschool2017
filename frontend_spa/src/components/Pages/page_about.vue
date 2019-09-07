<template lang="pug">
  .page.page_about
    section.sectionHero.theme.blue
      //- h1 關於我們
      img.coverGraphic.animated.fadeIn(src="/static/img/about_sectionAbout_BigD.png", 
      :style="{transform: `translateY(${scrollTop/3}px)`}")
      
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
              i.fa.fa-angle-left.mr-2
              | 返回總表
          .col-sm-9
            //- p(v-if="nowMember" v-html="nowMember.content")
            fullPage(@closeFullpage="nowMember=null", :show="nowMember")
              .container.float-card(v-if="nowMember")
                .row
                  .col-sm-3
                    .img(:style="cssbg(nowMember.cover)" )
                      .cata(v-if="memberCata[nowMember.cata-1]") {{memberCata[nowMember.cata-1].type}}
                  .col-sm-9
                    h3 {{nowMember.name}} 
                    h4.description.mb-3
                      span(v-if='nowMember.company') {{nowMember.company}}
                      span(v-if='nowMember.company') &nbsp;/&nbsp;
                      span {{nowMember.position}} 
                    p(v-html="nowMember.content")

            .col-sm-3.col-member.animated.fadeIn.mb-4(
              v-for="(member,mid) in filtered_teammember",
                     :class="'delay-ani-'+mid*1",
                     @click=" setActiveMember(member)")
              .img(:style="cssbg(member.cover)" )
                .cata(v-if="memberCata[member.cata-1]") {{memberCata[member.cata-1].type}}
                // router-link.edit_btn(v-if="is_admin", :to="`/manage/member/${member.id}`") 編輯
              h3 {{member.name}} 
              h5.description.mt-2(style="min-height: 3rem")
                span(v-if='member.company') {{member.company}}
                span(v-if='member.company') &nbsp;/&nbsp;
                span {{member.position}} 
              
</template>

<script>
import {mapState} from "vuex"
import {WOW} from "wowjs"
import fullPage from "@/components/fullPage"

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
         answer: "在創新創業風氣興盛後，臺大覺察學校創新教育的不足，在前校長楊泮池教授及前學術副校長陳良基教授等人的堅持與努力，並加入校友王大壯先生的捐贈，遂於2014年3月24日正式成立創新設計學院，2015年秋季正式開課，更於2018年起將創創學程與D-School合併共同運作，以整合全校創新創業資源，共同建構創新設計的教學課程與跨領域學習環境。<br>創新設計學院為全台大共有的學院，由校長就本校相關領域教授聘請執行長一名，負責統籌各院的需求成立跨領域的教學與研究的環境；置副執行長若干人，襄助執行長推動並執行業務；設諮詢委員會，由校內外相關領域專家薦請校長聘兼之。<br>目前學院共有4組，分別為建構創新設計的校內教學課程與學習環境為主的「創新教育組」；建置並執行創新創業學程，提供並扶植校內學生邁進創新創業之路的「創業教育組」；負責建立多元的跨領域學習機制、並媒合校原內外資源以突破大學與社會藩籬的「社會創新教育組」；以及增強並推廣學院對外相關教學課程與活動的「服務推廣組」。"
       },
       {
         question: "那麼～我要如何參與學院大小事呢？",
         answer: "如果你是～1.台大學生：可以選修學院所開設的學分課程，若是曾修過學院課程的學生，也能優先錄取工作坊講座等活動。<br>如果你是～2.台大老師：將自己的研究領域帶入學院課程中，並結合設計思考的方式，創造跨科系領域的課程體驗。<br>如果你是～3.非台大學生：除了學分課程的選修上較不易執行，亦能參加學院的大小活動及實作工作坊。也非常歡迎報名擔任學院小管家、課程助教、實作中心小老大、學術小組教練等。<br>如果你是～4.非台大老師：可以從參與學院不定期舉辦的各式活動或工作坊開始，可以先來瞭解學院實體運作。學院也非常歡迎大家將熱情與專業投入，進一步在學院申請開設零學分的工作坊等。亦或帶領自己的學生，一同參與「D-Day期末成果展」。"
       },
       {
         question: "我需要具備什麼樣的能力才能參與嗎？",
         answer: "我們希望在跨領域的合作能夠為專案提供更完善的解決方案，同時培養同學們合作與溝通的能力。因此，許多課程有可能會以大三大四同學優先錄取，但若是你真的很有興趣，大一大二也可以試著來報名喔!"
       },
       {
         question: "學院未來的目標是什麼？",
         answer: "台大創新設計學院現在仍只是推動創新教育的起步，期許未來能全面地影響台灣創造力與創新能力的教育，培養各領域的核心人才。在教學面，將整合校內外跨域師資及課程；在創業面，將建構創新創業生態，強化新創事業輔導與管理機制；在實作面，將擴展創客空間，建構創新設計聯盟；在社會面，將結合外部資源，形塑全球在地學習基地之共學生態系；在未來面，將發想並試驗未來教學，適時導入各類資源，增進師生創意、創新、創業、創生動能，使創意、創新、創業、創生成為本校在亞洲大學圈具有獨特的競爭優勢。"
       }
     ],
     memberCata:[
       {
         eng: "NIN_JA",
         label: "忍者",
         type: "行政團隊",
         img: "/static/img/about_sectionMembers_staffIcon1.svg"
       },{
         eng: "SEI_FU",
         label: "師傅!",
         type: "教學團隊",
         img: "/static/img/about_sectionMembers_staffIcon2.svg"
       },{
         eng: "NIN_JA",
         label: "徒弟~",
         type: "學生團隊",
         img: "/static/img/about_sectionMembers_staffIcon3.svg"
       },{
         eng: "SEI_SHUNG",
         label: "師兄",
         type: "歷屆夥伴",
         img: "/static/img/about_sectionMembers_staffIcon4.svg"
       }
     ],
     nowCata: -1,
     nowMember: null
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
              .slice().sort((a,b)=>a.order_id>b.order_id?1:-1)
    },
    isFullPageMemberOpened(){
      return this.nowMember?true:false
    }

  },
  components: {
    fullPage
  },
  methods: {

    setActiveMember(member){
      this.$set(this,"nowMember",member)
      console.log(member)
    }
  }
}
</script>

<style lang="sass">
</style>
