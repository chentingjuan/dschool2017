<template lang="pug">
.page.page_service
  section.sectionHero.blue
    //- h1 服務項目
    img.coverGraphic(src="/static/img/hero_service_cover.svg", :style="{transform: `translateY(${scrollTop/3}px)`}")
    //- img.coverGraphic(src="/static/img/about_sectionAbout_BigD.png")
  section.sectionAbout.theme.blue
    .container-fluid.theme.white.card
      .row.theme.orange
      .row
        .col-sm-2
          h2 服務項目
          hr
        .col-sm-10
          .row.row-content
            .col-sm-4(v-for="item in service_items")
              img.img_service(:src="item.image")
              h3 {{item.title}}
              p {{item.content}}
              .btn.orange(@click="scrollTo(item.scroll_target)",
                          v-if="item.btn_label") {{item.btn_label}}
        
  //section.sectionSpace.theme.blue
    .container-fluid
      .row
        .col-sm-4.col-section-info
          h3.eng Space
          h2 空間介紹
          hr
          .row
            .col-sm-12
              h3 位置
              p 位於臺大水源校區，可由汀州路轉入思源街(往永福橋方向)到達，辦公室位在卓越研究大樓409室。
              h3 教室
              p 學院內目前設有五間教室，分別為課程教室、討論間以及實作中心。
              //h3 可借用時段
              //p 當月20日起開放次月預約，開放時段為週一至週五，9:00至21:00本院有權保留教室調動權責(假日暫不開放)
        .col-sm-8.card.theme.orange.card-main-info
          .row.row-main-info
            .card.theme.white.card-main-space
              .col-sm-7.col-md-5.col-space-img
              .col-sm-5.col-md-7.col-info
                h3.roomname 404室
                h4 梯形教室
                p 為設計思考課程授課教室，亦作為學院工作坊空間及簡單會議空間。可容納25-30人使用。
                //.btn.orange 了解更多
          .row
            .col-sm-3(v-for="i in 4")
              img.img_room
              h4 404
              h5 梯形教室
  //section.sectionDevice.theme.blue
    .container-fluid
      .row
        .col-sm-7.card.theme.white
          .row
            .col-sm-4(v-for="i in 3").theme.white
              img.img_device(alt="設備圖片")
              h3 404室
              h4 梯形教室
              p 600流明<br>注意事項：<br>需要提前兩到三天先拿
              //.btn.btn-primary 了解更多

          
        .col-sm-5
          .row
            .col-sm-12
              h3.eng Device
              h2 設備租借
              hr
              p 填寫後請於Slack私訊負責人(liuliu)，經確認後才為借用成功。<br>(外單位請用Email通知負責人：jingyilin@ntu.edu.tw)<br><br>設備維護：請將借用物品完全恢復至借用前狀態(線材分別捲好、確認設備電源確實關閉)才歸還。若是假日借用，請將器材整理清點後拍照(須清楚看到所有配件)上傳至Slack群組#return，並鎖入設備箱內。<br><br>設備借用以在學院內使用為主，若有攜出使用需求請洽學院承辦人：靜怡(02-3366-1869 #55395)，詳情請見   攜出規範
              router-link.btn.orange(to="/service/equipment") 前往租借

  section.sectionWorkshop.theme.blue
    .container-fluid
      .theme.orange.card
        .row
          .col-sm-3
            .row
            h3.eng Workshop
            h2 申請工作坊
            hr
            p 本院目前提供下開方案供申請者依時間、需求申請。申請流程請依時間限制提前提出申請表。

            
          .col-sm-9
            .row
              .col-md-3.col-sm-6.col-xs-12.col-workshop(v-for="workshop in workshops")
                .duration {{workshop.length}}hr
                img.img_workshop(:src="workshop.cover")
                h3 {{workshop.title}}
                p {{workshop.content}}
                .btn.white(@click="setWorkshop(workshop)") 了解更多
            
    fullPage(@closeFullpage="nowWorkshop=null", :show="nowWorkshop")
      .container.float-card.theme.white(v-if="nowWorkshop")
        .row.text-left
          .col-sm-3
            img.img_workshop(:src="nowWorkshop.cover")
          .col-sm-9
            h3 {{nowWorkshop.title}}
            p.text-left
              b 課程長度：
              span(v-html="nowWorkshop.detail.length")
              br
              b 預約申請：
              span(v-html="nowWorkshop.detail.appointment")
              br
              b 課程人數／講師教練需求：
              span(v-html="nowWorkshop.detail.requirement")
              br
              b 目標：
              span(v-html="nowWorkshop.detail.target")
              br
              b 其他：
              span(v-html="nowWorkshop.detail.other")
              br
              b 課程內容：
              span(v-html="nowWorkshop.detail.content")
              br



</template>

<script>
import {mapState } from 'vuex'
import fullPage from "@/components/fullPage"
export default {
  mounted(){
  },
  data(){
   return {
     service_items: [
       {
         title: "學院空間使用",
         content: "創新設計學院配合課程、活動等多原用途，設計專屬空間。(僅開放學院課程與合作計畫借用申請。)",
        //  btn_label: "前往租借",
         image: "/static/img/service_3.svg",
         scroll_target: ".sectionSpace"
       },
       {
         title: "設備使用申請",
         content: "輔助課程、活動的重要角色；並可協助同學課程或專案執行。(僅開放學院課程與合作計畫申請。)",
        //  btn_label: "前往租借",
         image: "/static/img/service_2.svg",
         scroll_target: ".sectionDevice"
       },{
         title: "設計思考工作坊",
         content: "學院為推廣設計思考，量身打造實作類型工作坊，讓設計思考活用於生活中。",
         btn_label: "前往申請",
         image: "/static/img/service_1.svg",
         scroll_target: ".sectionWorkshop"
       }
     ],
    
    workshops: [
      {
        length: "?",
        cover: "/static/img/workshop_1.svg",
        title: "客製化工作坊",
        content: "認識設計思考，並運用設計思考流程解決特定問題",
        detail: {
          length: "可視實際需求調整",
          appointment: `1. 半日（3hr）活動需提前至少三週確認主題及活動目標<br>
          2. 全日或以上者需提前一個月申請`,
          requirement: "",
          other: "需至少進行三次事前會議<br>＊需求確認會<br>＊主題目標議定會<br>＊工作方流程協調會",
          target: "認識設計思考，並運用設計思考流程解決特定問題",
          content: `
          1. 需求確認會議三日內提交課程大綱<br>
          2. 主題議定會後一週內提供活動或課程企劃<br>
          3. 課程企劃提出後進行流程協調會議<br>
          4. 課程內容涵蓋體驗式前導活動專案前工作坊、專案規劃及執行協助，是單位需求議定<br>`
        }
      },{
        length: "3",
        cover: "/static/img/workshop_2.svg",
        title: "體驗工作坊",
        content: "認識設計思考，並運用互動練習體驗設計思考流程，初探設計思考概念(mindset)",
        detail: {
          length: "３小時以內",
          appointment: `需提前至少一週預約`,
          requirement: `＊１４人以內，１位講師，１位助教<br>
              ＊１４－２５人，１位講師，１位教練，１位助教<br>
              ＊２５人以上，１位講師，每１０人１位教練，１位助教`,
          other: "",
          target: "認識設計思考，並藉由互動練習體驗設計思考流程，初探設計思考概念(mindset)",
          content: `1. 演講：設計思考初探<br>
          2. 演講：設計思考流程解析<br>
          3. 流程演練(題目可視需求調整)<br>
          4. 初階—錢包練習<br>
          5. 進階—送禮練習<br>
`
        }
      },{
        length: "8",
        cover: "/static/img/workshop_3.svg",
        title: "概念工作坊",
        content: "認識惡既思考，暸解操作心法及體驗流程操作實務",
        detail: {
          length: "８小時以內(含用餐)",
          appointment: `需提前至少三週預約`,
          requirement: `＊１４人以內，１位講師，１位教練，１位助教<br>
                  ＊１４人以上，１位講師，每５－６人１位教練，１位助教`,
          other: "",
          target: "認識設計思考，暸解操作心法及體驗流程操作實務",
          content: `1. 預約時進行主題議定會，會後一週內提供活動或課程企劃<br>
                  2. 課程內容涵蓋概念介紹、案例解析、部分流程操作、工具演練，可視單位需求議定。
`
        }
      },{
        length: "16",
        cover: "/static/img/workshop_4.svg",
        title: "概念工作坊",
        content: "認識設計思考，暸解操作心法後，進行完整流程演練並能進一步思考應用",
        detail: {
          length: "兩日完整工作坊16hr(含用餐)",
          appointment: `需提前至少一個月預約`,
          requirement: `１２人以內，２位講師級教練，１位助教<br>
                  １２人以上，１位助教，每５－６人一位講師級教練`,
          other: "",
          target: "認識設計思考，暸解心法後，進行完整流程演練並能進一步思考應用",
          content: `1. 預約時進行需求確認會，會後三日提供課程大綱及主題規劃方向<br>
2. 主題議定會後一週內提供活動或課程企畫<br>
3. 課程內容涵蓋概念介紹、案例解析、完整流程操作、工具演練、田野應用、可視單位需求議定。
`
        }
      }
    ],
    nowWorkshop: null
   }

  },
  methods: {
    scrollTo(target){
      $("html,body").animate({scrollTop: $(target).offset().top }) 
    },
    setWorkshop(w){
      this.$set(this,"nowWorkshop",w)
    }
  },
  computed:{
    ...mapState(['scrollTop'])
  },
  components: {
    fullPage
  },
  created(){
    //load customized info and override default
    axios.get("/api/page/service").then(res=>{
      res.data.content = res.data.content? JSON.parse(res.data.content):{}
      Object.keys(res.data.content).forEach(key=>{
        console.log(key,res.data.content[key])
        this.$set(this,key,res.data.content[key])
      })
    })
  }
}
</script>

<style>

</style>
