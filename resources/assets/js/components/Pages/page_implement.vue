<template lang="pug">
  .page.page_implement
    section.sectionHero.blue
      //- h1 實作中心 D-SCHOOL
      img.coverGraphic(src="/img/GraphicImplementation.svg")
    section.sectionIntro.white
      .container
        .row
          .col-sm-5
            img(alt="3d printer")
          .col-sm-7
            h2 解放無限的潛能，每個人能夠動手做
            p 創新設計學院的實作中心，<br>為所有台大師生提供一個可親自動手實作、驗證設計的空間，<br>鼓勵勇於將想法化為現實而不怕失敗的創新精神。<br>中心內設有多種發想輔助工具、材料、輕型加工設備及手工具，<br>並不定期舉辦各式實作教學工作坊，增進台大師生的實作技巧。<br>此外中心開放時間常駐有管理團隊輪值，確保使用者之安全。<br>
    section.sectionJump
      .container-fluid
        .row
          .col-sm-6
          .col-sm-6
    section.sectionRule.grey
      h3.eng Rules
      h2 使用規則
      hr
      .panel.white
        .row
          .col-sm-4
            h3 開放對象
            p 台大全體師生(創新設計學院師生優先)，及向創新設計學院申請通過者。
            br
            h3 開放時間
            p 週一 / 週四 / 週五，09:00-16:30。<br>不含例假日及學院課程活動使用時間，<br>寒暑假辦法另行公告。

          .col-sm-8
            h3 注意事項
            ul
              li 1.    使用過程中確實遵守各項安全守則，並遵從管理人員指示，如有任何問題請至管理櫃檯洽詢
              li 禁止擅自攜帶非課程、業務相關人員進入避免造成危險
              li 工具材料限於學院內使用，並當日完成歸還(經申請許可者除外)
              li 實作中心鼓勵眾人分享作品與回饋，但中心內創作的一切智慧財產權仍完全規原創作者所有
              li 實作中心以協助製作創新原型為主要功能，不提供商業用途之大量製造
              li 本要點如有不足之處，應依創新設計學院之規定；創新設計學院保留修改本要點之權利

    section.sectionProgress.blue
      h3.eng Progress
      h2 使用流程
      hr
      .container
        .row
          .col-sm-3
            img(alt="icon")
            h3 
              span.num 1.
              span 登記
            p 於開放時間持證件至卓越大樓405管理櫃台，登記使用設備、材料、空間，及時間。
            .btn.white.outline 登記使用
          
          .col-sm-3
            img(alt="icon")
            h3 
              span.num 2.
              span 驗證
            p 經管理人員確認身分符合且確實了解設備操作方式後，繳交證件即可使用空間及設備。
            .btn.white.outline 申請驗證
          
          .col-sm-3
            img(alt="icon")
            h3 
              span.num 3.
              span 清潔
            p 使用結束後妥善清潔場地、設備並復原環境。
          .col-sm-3
            img(alt="icon")
            h3 
              span.num 4.
              span 檢查
            p 至管理櫃台請管理人員檢查確認，確認無誤後登記取回證件。

    section.sectionDevices.white
      h3.eng Devices
      h2 設備一覽
      hr
      .container
        .row
          .col-sm-3
          .col-sm-3
          .col-sm-3
          .col-sm-3
        .row
          .col-sm-3
          .col-sm-3
          .col-sm-3
          .col-sm-3

    section.sectionQuestion.white
      h3.eng Q&A
      h2 常見問題
      hr
      .container
        .row(v-for="qa in qas")
          .col-sm-4 
            h3(v-html="qa.question")
          .col-sm-8
            p(v-html="qa.answer")
</template>

<script>
export default {
  data(){
    return {
      qas: [
        {
          question: "要如何使用學院的3D列印機與雷射切割機?",
          answer: "3D列印機與雷射切割機需具有學院認證紀錄才可使用<br>通過認證後可於開放時間至R405向管理人員登記使用<br>註：3D列印酌收基本材料費，雷射切割需自備板材，價目請洽R405管理櫃台"
        },
        {
          question: "如何進行3D列印機與雷射切割機認證?",
          answer: "於實作中心開放時間至R405預約認證時間，並於預約時間請管理人員教學認證<br>註：單一項目約需1.5小時"
        },
        {
          question: "實作中心有無販售材料?",
          answer: "實作中心目前有販售少量密集板與壓克力板，品項與價格細目請洽R405管理櫃台"
        },
        {
          question: "工作坊錄取通知會如何通知?何時通知?",
          answer: "實作中心工作坊錄取通知一般以e-mail通知通知時間詳列於每次活動公告內"
        }
      ]
    }
  }
}
</script>

<style>

</style>
