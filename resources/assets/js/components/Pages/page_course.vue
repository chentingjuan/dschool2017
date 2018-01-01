<template lang="pug">
.page.page_course
  section.sectionHero.blue
    h1 課程
    //- img.coverGraphic(src="/img/question_cover.svg")
  section.sectionAbout.theme.white
    .container.theme.white
      .row
        .col-sm-12
          h2 課程簡介
          hr
          p 創新設計學院為培養顛覆性創新、跨領域溝通的人才，以六大核心能力為基礎，開設四大課群課程。
            | <br>從以人為本的起始點出發，讓跨科系的同學共同合作，解決社會真實問題，在課程中特別加強：橫向溝通合作的應變能力；資料量化分析；動手實作做精神；訊息傳達技巧；激發創意的領導力。
            | <br>並規劃核心課程(DS5100系列)、工作坊課程(DS5200系列)、專題課程(DS5300系列)、國際與企業專題(DS5400系列)，建立學生從觀察發現問題開始，到生活議題的探討，擴大國際視野。
            | <br>然而，發想創意及解決問題的過程中總是橫亙著許多的阻礙，學院為使創新的苗芽順利成長、實際測試其想法的可行性，學院提供前端的豐沛資源：課程資金的挹注、打造討論與實作空間、將外界資源納入校園，舉辦講座或工作坊活動，積極與外部單位合作，如桃園機場、台大兒童醫院、癌症基金會等。
            | <br>我們同時也期盼更多創新創意持續進行，在期末舉辦大型聯合發表會D-Day；推動接續D-Course的延伸計劃D-Plan。讓經驗的累積不受學期的影響，更期許學院課程成為同學人生轉變的契機。
  section.sectionAbout
    .container.theme.blue
      .row
        .col-sm-12
          h2 四大課群
          hr
      .row
        .col-sm-3(v-for='i in 4')
          img
          h4 DS5100系列
          h3 核心課程
          p 建立學生觀察與解決問題的核心能力,讓學生具備合作發想與創新再造之能力｡課程包含:設計思考､使用者心理､說故事能力培養､腦力激盪､團隊合作技巧…等課程。
  section.sectionAbility
    .container.theme.white
      .row
        .col-sm-12 
          h2 六大核心能力
      .row
        .col-sm-12
          .row
            .col-sm-3
            .col-sm-9
              h3 Mindset
              p 建立T型人才中橫向的學習､溝通､合作與應變能力
  section.sectionCurrent
    .container.theme.blue
      .row
        .col-sm-12 
          h2 當期課程列表
      .row
        .col-sm-12
          .row
            .col-sm-3
            .col-sm-9
              h3 Mindset
              p 建立T型人才中橫向的學習､溝通､合作與應變能力
  section.sectionWish
    .container.theme.blue
      .row
        .col-sm-12 
          h2 許願池
      .row
        .col-sm-12
          .row
            .col-sm-12

</template>

<script>
export default {

}
</script>

<style>

</style>
