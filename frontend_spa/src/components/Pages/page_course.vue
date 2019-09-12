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
          p 創新設計學院為培養顛覆性創新、跨領域溝通的人才，以五大核心能力為基礎，開設四大課群課程。在發想創意及解決問題的過程中總是橫亙著許多的阻礙，學院為使創新的苗芽順利成長、實際測試其想法的可行性，學院提供許多前端的豐沛資源，如課程資金的挹注、打造討論與實作空間、將外界資源納入校園、舉辦講座或工作坊活動，並積極尋求與外部單位的專案合作，如桃園機場、台大兒童醫院、癌症基金會等。 <br>
            | 我們同時也期盼更多創新創意持續進行，在期末舉辦大型聯合發表會D-Day；推動接續D-Course的延伸計劃D-Plan。讓經驗的累積不受學期的影響，更期許學院課程成為同學人生轉變的契機。

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
  section.sectionAbility
    .container.theme.blue
      .row
        .col-sm-12 
          h2.text-color.white 五大核心能力
          hr
      .row.text-center
        div(v-for="ab in abilities", style="flex: 1;")
          .row
            .col-12
              div.icon-container
                div.icon
                  img(:src="ab.img")
              div.pl-3.pl-3
                h3.text-color.orange {{ ab.label }}
                p.text-color.white.mt-2 {{ ab.description }}

  section.sectionCurrent
    .container.theme.blue
      .row
        .col-sm-12 
          h2 課程列表
          hr
          span.float-right.text-color.orange
            i.fa.fa-check 
            span &nbsp;當期開設
      .row
        .col-sm-12(v-for="(cdata,cid) in sortedCourses")
          .row.row-planet.animated.fadeIn(:class="'delay-ani-'+cid*2")
            .col-sm-4.col-img
              img(:src="cdata.planetSrc")
            .col-sm-8.col-info
              h3 {{cdata.title}}
                span.text-color.orange(v-if="cdata.current") &nbsp;
                  i.fa.fa-check
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
          code: "Mindset Courses",
          title: "核心課程",
          description: "課程目標為讓學生可以培養出解決問題所需的Mindset。課程包含: 設計思考入門､設計思考､需求探索､設計如何說故事等課程。"
        },
        {
          img: "/static/img/course_cata_2.svg",
          code: "Skill Courses",
          title: "實作能力",
          description: "課程目標為讓學生可以練習新的Skill，強化創新構想的形成與執行，課程包含木工藝實作､創新原型實作､音樂設計與創新應用､影像戰鬥營等課程。",
        },
        {
          img: "/static/img/course_cata_3.svg",
          code: "Project Courses",
          title: "解決問題",
          description: "課程目標為讓學生可以整合多種Skill來針對生活中各類實際議題，如能源､人口､交通､居住､農業､環保､年長者關懷､醫療體系等等，探討可行且創新的解決方案，課程包含創新車輛設計､暖科技､智齡設計､使用者空間營造､全球創新的原理與實踐等。",
        },
        {
          img: "/static/img/course_cata_4.svg",
          code: "International and Corporate Projects",
          title: "國際與企業專題",
          description: "聚焦業界或國際社會問題加以發想,以學生與校外人士共同發展並實踐創新成果為主軸,建立學生跨入社會實務的基礎與國際觀｡",
        }
      ],
      abilities: [
        {
          label: "Mindset",
          description: "建立T型人才中橫向的學習､溝通､合作與應變能力",
          img: "/static/img/course_icon_ability_mindset.svg"
        },
        {
          label: "Making",
          description: "培養動手做的精神與能力",
          img: "/static/img/course_icon_ability_making.svg"
        },
        {
          label: "Analysis",
          description: "培養資料量化與分析能力",
          img: "/static/img/course_icon_ability_analysis.svg"
        },
        {
          label: "Creativity",
          description: "提昇創新發想能力",
          img: "/static/img/course_icon_ability_creativity.svg"
        },
        {
          label: "Storytelling",
          description: "提升團隊或個人的敘事、溝通能力，以產生有效益的訊息傳達",
          img: "/static/img/course_icon_ability_storytelling.svg"
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
