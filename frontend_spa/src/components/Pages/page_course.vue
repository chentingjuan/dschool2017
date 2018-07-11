<template lang="pug">
.page.page_course
  section.sectionHero.blue
    //- h1 學院課程
    img.coverGraphic(src="/static/img/hero_course_cover.svg",  :style="{transform: `translateY(${scrollTop/3}px)`}")
    //- img.coverGraphic(src="/static/img/question_cover.svg")
  section.sectionAbout.theme.blue
    .container
      .row
        .col-sm-8.theme.white
          h2 課程簡介
          hr
          p 創新設計學院為培養顛覆性創新、跨領域溝通的人才，以六大核心能力為基礎，開設四大課群課程。
            | <br>從以人為本的起始點出發，讓跨科系的同學共同合作，解決社會真實問題，在課程中特別加強：橫向溝通合作的應變能力；資料量化分析；動手實作做精神；訊息傳達技巧；激發創意的領導力。
            | <br>並規劃核心課程(DS5100系列)、工作坊課程(DS5200系列)、專題課程(DS5300系列)、國際與企業專題(DS5400系列)，建立學生從觀察發現問題開始，到生活議題的探討，擴大國際視野。
            | <br>然而，發想創意及解決問題的過程中總是橫亙著許多的阻礙，學院為使創新的苗芽順利成長、實際測試其想法的可行性，學院提供前端的豐沛資源：課程資金的挹注、打造討論與實作空間、將外界資源納入校園，舉辦講座或工作坊活動，積極與外部單位合作，如桃園機場、台大兒童醫院、癌症基金會等。
            | <br>我們同時也期盼更多創新創意持續進行，在期末舉辦大型聯合發表會D-Day；推動接續D-Course的延伸計劃D-Plan。讓經驗的累積不受學期的影響，更期許學院課程成為同學人生轉變的契機。
        .col-sm-4
          img(src="/static/img/earth.svg")
  section.sectionCatas
    .container.theme.blue
      .row
        .col-sm-12
          h2 四大課群
          hr
      .row
        .col-sm-3(v-for='cata in catas')
          img(:src="cata.img")
          h4 {{cata.code}}系列
          h3 {{cata.title}}
          p(v-html="cata.description")
  //- section.sectionAbility
    .container.theme.white.card
      .row
        .col-sm-12 
          h2 六大核心能力
      .row
        .col-sm-6(v-for="ab in abilities")
          .row
            .col-sm-3
            .col-sm-9
              h3 {{ ab.label }}
              p {{ ab.description }}
  section.sectionCurrent
    .container.theme.blue
      .row
        .col-sm-12 
          h2 當期課程列表
          hr
      .row
        .col-sm-12(v-for="(cdata,cid) in sortedCourses")
          .row.row-planet.animated.fadeIn(:class="'delay-ani-'+cid*2")
            .col-sm-4.col-img
              img(:src="cdata.planetSrc")
            .col-sm-8.col-info
              h3 {{cdata.title}}
              h4 {{cdata.code}} {{ cdata.type }}
              hr
              p(v-html="cdata.content")
  section.sectionWish.theme.blue
    img.cover.planet_end(src="/static/img/course_wish.svg",
              :style="{bottom: zPan+'px'}")
    .container.animated.fadeIn
      .row
        .col-sm-12 
          h2 許願池
          hr
      .row
        .col-sm-6.col-sm-offset-6
          h3 『來不及許願的流星，再怎麼美麗也只能是曾經！』
          p 我們提供大家永恆的許願池，若有想到任何希望學院開設的課程，都請大膽的投到許願池中，提供的線索（主題、講師、對象、目標等）越詳細越容易實現喔！
          .btn.white(@click="wishing=true", v-if="!wishing") 我要許願！
          h4.mt-3.fadeInUp.animated(v-if="wishFinish") 願望已發送到外太空囉！
          transition(name="fade")
            div(v-if="wishing && !wishFinish")
              textarea(rows=5 v-model="wishContent")
              .btn.white(@click="sendWish") 送出願望
           

</template>

<script>
import {mapState} from 'vuex'
import $ from 'jquery'
// import courseData from '../Data/courseDatas.js'
export default {
  data(){
    return {
      wishing: false,
      wishFinish: false,
      wishContent: "",
      // courseData,
      catas: [
        {
          img: "/static/img/course_cata_1.svg",
          code: "DS5100",
          title: "核心課程",
          description: "建立學生觀察與解決問題的核心能力,讓學生具備合作發想與創新再造之能力｡課程包含:設計思考､使用者心理､說故事能力培養､腦力激盪､團隊合作技巧…等課程。"
        },
        {
          img: "/static/img/course_cata_2.svg",
          code: "DS5200",
          title: "工作坊課程",
          description: "增強學生實作的能力與五感的敏銳度,協助學生強化創新構想的形成與執行,課程包含: 3D列印實務､簡報技巧､大數據分析､手繪訓練､色彩學､APP撰寫､縫紉技巧…等課程。",
        },
        {
          img: "/static/img/course_cata_3.svg",
          code: "DS5300",
          title: "專題課程",
          description: "針對生活中各類實際議題,探討可行且創新的解決方案,課程涉及層面涵蓋:能源､人口､交通､居住､農業､環保､年長者關懷､醫療體系…等。",
        },
        {
          img: "/static/img/course_cata_4.svg",
          code: "DS5400",
          title: "國際與企業專題",
          description: "聚焦業界或國際社會問題加以發想,以學生與校外人士共同發展並實踐創新成果為主軸,建立學生跨入社會實務的基礎與國際觀｡",
        }
      ],
      abilities: [
        {
          label: "Mindset",
          description: "建立T型人才中橫向的學習､溝通､合作與應變能力"
        },
        {
          label: "Make",
          description: "培養動手做的精神與能力"
        },
        {
          label: "Communication",
          description: "提升團隊或個人溝通技巧有效益取得與傳輸資訊"
        },
        {
          label: "Creativity",
          description: "提昇創新發想能力"
        },
        {
          label: "Analysis",
          description: "培養資料量化與分析能力"
        },
        {
          label: "Storytelling",
          description: "產生有效益的訊息傳達"
        }
      ]
    }
  },
  computed:{
    ...mapState(['courses','scrollTop']),
    sortedCourses(){
      return this.courses.sort((a,b)=>{
        return a.order_id>b.order_id?1:-1
      })
    },
    zPan(){
      return -( this.scrollTop / $("html").height())*window.innerHeight/1.5+window.innerHeight/2+50
    }
  },
  methods: {
    sendWish(){
      axios.post("/api/course/wish",{
        content: this.wishContent
      }).then(()=>{
        this.wishFinish=true
      })
    }
  }
}
</script>

<style>

</style>
