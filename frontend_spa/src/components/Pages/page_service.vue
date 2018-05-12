<template lang="pug">
.page.page_service
  section.sectionHero.blue
    //- h1 服務項目
    img.coverGraphic(src="/static/img/hero_service_cover.svg")
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
              .btn.orange(@click="scrollTo(item.scroll_target)") {{item.btn_label}}
  section.sectionSpace.theme.blue
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
              h3 可借用時段
              p 當月20日起開放次月預約，開放時段為週一至週五，9:00至21:00本院有權保留教室調動權責(假日暫不開放)
        .col-sm-8.card.theme.orange.card-main-info
          .row.row-main-info
            .card.theme.white.card-main-space
              .col-sm-7.col-md-5.col-space-img
              .col-sm-5.col-md-7.col-info
                h3.roomname 404室
                h4 梯形教室
                p 為設計思考課程授課教室，亦作為學院工作坊空間及簡單會議空間。可容納25-30人使用。
                .btn.orange 了解更多
          .row
            .col-sm-3(v-for="i in 4")
              img.img_room
              h4 404
              h5 梯形教室
  section.sectionDevice.theme.blue
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
      .row.card.theme.orange
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
              .btn.white 了解更多
            



</template>

<script>
export default {
  mounted(){
  },
  data(){
   return {
     service_items: [
       {
         title: "學院空間使用",
         content: "創新設計學院配合課程、活動等多原用途，設計專屬空間。(僅開放學院課程與合作計畫借用申請。)",
         btn_label: "前往租借",
         image: "/static/img/service_3.svg",
         scroll_target: ".sectionSpace"
       },
       {
         title: "設備使用申請",
         content: "輔助課程、活動的重要角色；並可協助同學課程或專案執行。(僅開放學院課程與合作計畫申請。)",
         btn_label: "前往租借",
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
        content: "認識設計思考，並運用設計思考流程解決特定問題"
      },{
        length: "3",
        cover: "/static/img/workshop_2.svg",
        title: "體驗工作坊",
        content: "認識設計思考，並運用互動練習體驗設計思考流程，初探設計思考概念(mindset)"
      },{
        length: "8",
        cover: "/static/img/workshop_3.svg",
        title: "概念工作坊",
        content: "認識惡既思考，暸解操作心法及體驗流程操作實務"
      },{
        length: "16",
        cover: "/static/img/workshop_4.svg",
        title: "概念工作坊",
        content: "認識設計思考，暸解操作心法後，進行完整流程演練並能進一步思考應用"
      }
    ],
    
   }

  },
  methods: {
    scrollTo(target){
      $("html,body").animate({scrollTop: $(target).offset().top }) 
    }
  }
}
</script>

<style>

</style>
