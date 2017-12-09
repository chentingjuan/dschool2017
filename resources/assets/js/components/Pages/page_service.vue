<template lang="pug">
.page.page_service
  //section.sectionHero.blue
    h1 服務項目
    //img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    img.coverGraphic(src="/img/about_sectionAbout_BigD.png")
  //section.sectionAbout.theme.blue
    .container-fluid.theme.white.card
      .row
        .col-sm-2
          h2 服務項目
          hr
        .col-sm-10
          .row
            .col-sm-4(v-for="i in 3")
              h3 租借場地
              p 創新設計學院的實作中心，為所有台大師生提供一個可親自動手實作、驗證設計的空間，
              .btn.btn-primary 前往租借
  //section.sectionSpace.theme.blue
    .container-fluid.theme
      .row
        .col-sm-4
          h3.eng Space
          h2 租借場地
          hr
          .row
            h4 位置
            p 位於臺大水源校區，可由汀州路轉入思源街(往永福橋方向)到達，辦公室位在卓越研究大樓409室。
            h4 教室
            p 學院內目前設有五間教室，分別為課程教室、討論間以及實作中心。
            h4 可借用時段
            p 當月20日起開放次月預約，開放時段為週一至週五，9:00至21:00本院有權保留教室調動權責(假日暫不開放)
        .col-sm-8
          .row
            .card.theme.white
              .col-sm-7
                img(alt="pic")
              .col-sm-5
                h3 404室
                h4 梯形教室
                p 為設計思考課程授課教室，亦作為學院工作坊空間及簡單會議空間。可容納25-30人使用。
                .btn.btn-primary 了解更多
          .row
            .col-sm-3(v-for="i in 4")
              h4 404
              h5 梯形教室
  section.sectionDevice.theme.blue
    .container-fluid
      .row.card.white
        .col-sm-7
          .row
            .col-sm-4(v-for="i in 3").theme.white
              img.img_device(alt="設備圖片")
              h3 404室
              h4 梯形教室
              p 600流明<br>注意事項：<br>需要提前兩到三天先拿
              //.btn.btn-primary 了解更多

          
        .col-sm-5
          h3.eng Device
          h2 設備租借
          hr
          p 填寫後請於Slack私訊負責人(liuliu)，經確認後才為借用成功。<br>(外單位請用Email通知負責人：jingyilin@ntu.edu.tw)<br><br>設備維護：請將借用物品完全恢復至借用前狀態(線材分別捲好、確認設備電源確實關閉)才歸還。若是假日借用，請將器材整理清點後拍照(須清楚看到所有配件)上傳至Slack群組#return，並鎖入設備箱內。<br><br>設備借用以在學院內使用為主，若有攜出使用需求請洽學院承辦人：靜怡(02-3366-1869 #55395)，詳情請見   攜出規範
          .btn.btn-primary 前往租借

  section.sectionWorkshop.theme.blue
    .container-fluid
      .row.card.theme.orange
        .col-sm-2
          .row
          h3.eng Workshop
          h2 申請工作坊
          hr
          p 本院目前提供下開方案供申請者依時間、需求申請。申請流程請依時間限制提前提出申請表。

          
        .col-sm-10
          .row
            .col-sm-3(v-for="i in 4")
              img.img_device(alt="設備圖片")
              h3 客製化工作坊
              p 認識設計思考，並運用設計思考流程解決特定問題
              .btn.white 了解更多
            



</template>

<script>
export default {
  data(){
   return {}
   
  }
}
</script>

<style>

</style>
