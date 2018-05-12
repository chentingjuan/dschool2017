<template lang="pug">
  .page.page_implement
    section.sectionHero.blue
      //- h1 實作中心 D-SCHOOL
      img.coverGraphic(src="/static/img/hero_maker_cover.svg")
      .status
        .text 開放時間：{{status_text}}
        br
        ul.available_time
          li(v-for="d in day_status",
            :class="{open: d.open}") {{d.label}}
      
    section.sectionIntro.theme.white
      .container
        .row
          .col-sm-5
            img.printer(src="/static/img/implement_3dprinter.svg")
          .col-sm-7.col-info
            h2.secondary 解放無限的潛能，每個人能夠動手做
            p 創新設計學院的實作中心，<br>為所有台大師生提供一個可親自動手實作、驗證設計的空間，<br>鼓勵勇於將想法化為現實而不怕失敗的創新精神。<br>中心內設有多種發想輔助工具、材料、輕型加工設備及手工具，<br>並不定期舉辦各式實作教學工作坊，增進台大師生的實作技巧。<br>此外中心開放時間常駐有管理團隊輪值，確保使用者之安全。<br>
      
    section.sectionJump
      .container-fluid
        .row
          .col-sm-6.theme.orange(@click="scrollTo('.sectionRule')")
            h3 Rules
            h2 使用規則
            
          .col-sm-6.theme.blue(@click="scrollTo('.sectionDevices')")
            h3 Equipments
            h2 相關設備

    section.sectionRule.theme.blue
      img.bg(src="/static/img/cover_maker_lights.svg")
      .container
        .row
          .col-sm-12
            h3.eng Rules
            h2 使用規則
            hr
          .col-sm-12
            .row
              .col-sm-4
                h3 開放對象
                p 台大全體師生(創新設計學院師生優先)，<br>及向創新設計學院申請通過者。
                br
                h3 開放時間
                p 週一 / 週二 / 週四，09:00-16:30。<br>若與例假日、學院課程活動使用衝突則不開放使用。<br>（請參閱學院活動行事曆。）<br>寒暑假不開放，D-Plan專案申請者除外。

              .col-sm-8.card.theme.white
                h3 使用規則
                br
                p
                  | 1. 請遵照『實作中心使用流程』申請及登記使用。<br>
                  | 2. 3D列印機與雷射切割機需具有學院認證紀錄才可使用。（登記認證程序同使用流程）<br>
                  | 3. 實作中心僅販售少量密集板、壓克力板、3D列印等材料，不提供大量製造與材料訂購。（品項與價格細目請洽R405管理櫃台。）<br>
                  | 4. 請務必遵守各項安全守則，並遵從管理人員指示。

                h3 注意事項
                br
                p
                  | 1. 禁止擅自攜帶非課程、業務相關人員進入，避免造成危險 。
                  | <br>2. 工具材料限於學院內使用，並當日完成歸還(經申請許可者除外) 。
                  | <br>3. 實作中心鼓勵眾人分享作品與回饋，但中心內創作的一切智慧財產權仍完全歸原創作者所有。
                  | <br>4. 實作中心以協助製作創新原型為主要功能，不提供商業用途之大量製造。
                  | <br><br>＊創新設計學院保留修改本要點之權利

    section.sectionProgress.theme.white
      .container
        .row
          .col-sm-12
            h3.eng Progress
            h2 使用流程
            hr
            
        .row
          .col-sm-3.col-progress
            img.img-progress(src="/static/img/maker_progress_1.svg")
            h3 
              span.num 1
              span 登記
            p 於開放時間持證件至卓越大樓405管理櫃台，登記使用設備、材料、空間，及時間。
            //- .btn.orange.outline 登記使用
          
          .col-sm-3.col-progress
            img.img-progress(src="/static/img/maker_progress_2.svg")
            h3 
              span.num 2
              span 驗證
            p 經管理人員確認身分符合且確實了解設備操作方式後，繳交證件即可使用空間及設備。
            //.btn.white.outline 申請驗證
          
          .col-sm-3.col-progress
            img.img-progress(src="/static/img/maker_progress_3.svg")
            h3 
              span.num 3
              span 清潔
            p 使用結束後妥善清潔場地、設備並復原環境。
          
          .col-sm-3.col-progress
            img.img-progress(src="/static/img/maker_progress_4.svg")
            h3 
              span.num 4
              span 檢查
            p 至管理櫃台請管理人員檢查確認，確認無誤後登記取回證件。

    section.sectionDevices.theme.blue
      .container
        .row
          .col-sm-12
            h3.eng Devices
            h2 設備一覽
            hr
            .container
              .row
                .col-sm-3(v-for="equip in equipments")
                  .equip(:style="cssbg(equip.cover)")
                    .name {{equip.name}}

    //- section.sectionQuestion.theme.blue
    //-   .container
    //-     .row
    //-       .col-sm-12
    //-         h3.eng Equipments
    //-         h2 設備ㄧ覽
    //-         hr
        //.row(v-for="qa in qas")
          .col-sm-4 
            h4.theme.blue.question(v-html="qa.question")
          .col-sm-8
            p.answer(v-html="qa.answer")
</template>

<script>
export default {
  data(){
    return {
      day_status: [
        {
          label: "ㄧ",
          open: true
        }, {
          label: "二",
          open: true
        }, {
          label: "三",
          open: false
        }, {
          label: "四",
          open: true
        }, {
          label: "五",
          open: false
        }, {
          label: "六",
          open: false
        }, {
          label: "日",
          open: false
        }
      ],
      equipments: [
        {
          name: "MDX40A",
          cover: "/static/img/equipments_maker/MDX40A.jpg"
        },
        {
          name: "rep2x",
          cover: "/static/img/equipments_maker/rep2x.png"
        },
        {
          name: "replicator",
          cover: "/static/img/equipments_maker/replicator_default.png"
        },
        {
          name: "Universal VLS",
          cover: "/static/img/equipments_maker/Universal VLS 6.60.jpg"
        },
        {
          name: "Up Box",
          cover: "/static/img/equipments_maker/Box.png"
        },
        {
          name: "手持線鋸",
          cover: "/static/img/equipments_maker/手持線鋸.jpg"
        },
        {
          name: "鑽床",
          cover: "/static/img/equipments_maker/鑽床.jpg"
        },
        {
          name: "奶油蒼蠅",
          cover: "/static/img/equipments_maker/奶油蒼蠅.png"
        }
      ]
    }
  },
  computed:{
    status_text(){
      return this.day_status.filter(o=>o.open).map(t=>"週"+t.label).join(" / ")
    }
  }
}
</script>

<style>

</style>
