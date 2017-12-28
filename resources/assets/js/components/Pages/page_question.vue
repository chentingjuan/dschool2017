<template lang="pug">
  .page.page_question
    section.sectionHero.blue
      //- h1 常見問題
      img.coverGraphic(src="/img/question_cover.svg")
    section.sectionIntro.theme.white
      .container
        .row
          .col-sm-11.col-sm-offset-2.col-md-offset-1.col-lg-offset-0(v-for="(question,qid) in questions",
                     :class="'q'+qid")
            h2 {{question.title}}
            p(v-html="question.content")
            br
      .anchors
        ul
          li(v-for="(question,qid) in questions",
             @click="scrollTo('.q'+qid,{pan:-80})") {{question.title}}



</template>

<script>
export default {
  data(){
    return {
      questions: [
        {
          "title": "我想要參觀D-School?",
          "content": "<p>學院參訪以團體為主，並無固定參訪及導覽時段，請來信或來電預約：</p>\n\n<p>E-mail：<a href=\"mailto:ntudschool@ntu.edu.tw?subject=%E6%88%91%E6%83%B3%E8%A6%81%E5%8F%83%E8%A7%80D-School\">ntudschool@ntu.edu.tw</a></p>\n\n<p>Phone：(02) 3366-1869</p>"
        },
        {
          "title": "我想要來D-School修課",
          "content": "<ul>\n\t<li>學院課程分為有學分課程及無學分課程，目前因資源有限，除特殊專案另行招募外，各類工作坊及課程僅限台大學生選修。</li>\n\t<li>有學分課程將依臺灣大學教務處公告之時間開放選課，或可點選「學院課程」分頁查詢最新一學期之課程列表及選課資訊。</li>\n\t<li>其餘所有工作坊及活動報名資訊統一露出於學院官網「學院活動」頁面與Fb粉絲頁，請持續關注。</li>\n\t<li>針對開放校外人士可修習的課程，將不定期公告於網站中。</li>\n</ul>"
        },
        {
          "title": "我想要採訪",
          "content": "<p>學院採訪、媒體露出或課程合作相關事宜，敬請預先來信或來電接洽：</p>\n\n<p><strong>「課程相關」</strong></p>\n\n<p>聯繫窗口：課務&nbsp;王俞文 小姐</p>\n\n<p>聯絡電話：(02) 3366-1869http://dschool.ntu.edu.tw/55383</p>\n\n<p>E-mail &nbsp; &nbsp;：yuwen1201@ntu.edu.tw</p>\n\n<p><strong>「合作相關」&nbsp;</strong></p>\n\n<p>聯繫窗口：行政組 劉建成 先生</p>\n\n<p>聯絡電話：(02) 3366-1869http://dschool.ntu.edu.tw/55385&nbsp;</p>\n\n<p>E-mail &nbsp; &nbsp;：raxliu@ntu.edu.tw</p>"
        },
        {
          "title": "我要借場地",
          "content": "<ol>\n\t<li>台大師生於實作中心開放時間持證件至學院即可使用實作中心(週一至五09:00至16:30，不含例假日及學院課程、活動使用時間)。使用流程請參閱「實作中心開放要點」<a href=\"http://140.112.179.90:5000/fbsharing/GNk02fjD\">實作中心開放要點<img alt=\"\" src=\"/assets/image/download.png\" style=\"width: 19px; height: 17px;\"></a></li>\n\t<li>任何其他場地使用事宜詢問，請E-mail至學院信箱：ntudschool@ntu.edu.tw</li>\n</ol>"
        },
        {
          "title": "我要找合作",
          "content": "<p>我們非常願意在課程、教育推廣，或是委託案與校外單位合作，敬請來信或來電洽詢：</p>\n\n<p><strong>「課程相關」</strong></p>\n\n<p>聯繫窗口：課務&nbsp;王俞文 小姐</p>\n\n<p>聯絡電話：(02) 3366-1869http://dschool.ntu.edu.tw/55383</p>\n\n<p>E-mail &nbsp; &nbsp;：yuwen1201@ntu.edu.tw</p>\n\n<p><strong>「活動/合作相關」&nbsp;</strong></p>\n\n<p>聯繫窗口：行政組 劉建成 先生</p>\n\n<p>聯絡電話：(02) 3366-1869http://dschool.ntu.edu.tw/55385&nbsp;</p>\n\n<p>E-mail &nbsp; &nbsp;：raxliu@ntu.edu.tw</p>"
        },
        {
          "title": "我想要開DS課",
          "content": "<p>請參考<a href=\"http://140.112.179.90:5000/fbsharing/8aU1CXqf\" target=\"_blank\">開課流程圖<img alt=\"流程圖\" src=\"/assets/image/download.png\" style=\"width: 19px; height: 17px;\"></a>，或請與學院課務人員聯繫相關事宜。 聯絡電話：(02)3366-1869 分機&nbsp;55383 王俞文小姐</p>"
        },
        {
          "title": "我想要開0學分課程",
          "content": "<p>請參考<a href=\"http://140.112.179.90:5000/fbsharing/8aU1CXqf\">0學分開課流程圖，或請與學院課務人員聯繫相關事宜。 聯絡電話：3366-1869 分機&nbsp;55383 王俞文小姐</p>"
        },
        {
          "title": "我想要來旁聽",
          "content": "<p>為鼓勵本校師生參與學院課程，若想旁聽學院開授之課程，請與該課程授課教師聯繫取得同意後，即可旁聽上課。若未取得授課老師同意，該課程恕難開放旁聽。</p>"
        },
        {
          "title": "我想要申請課程經費",
          "content": "<p>若為該學期核准之開設課程將依據『國⽴臺灣大學創新設計學院授課獎勵補助辦法』規定辦理 ; 若為0學分課程，請與學院課務人員聯繫經費申請相關事宜。<br>\n勵補助辦法：<a href=\"http://140.112.179.90:5000/fbsharing/4eI7R94S\"><img alt=\"\" src=\"/assets/image/download.png\" style=\"width: 19px; height: 17px;\"></a><br>\n聯絡電話：(02)3366-1869 分機&nbsp;55383 王俞文小姐</p>"
        },
        {
          "title": "我要上0學分課程",
          "content": "學院將不定期開設各式實作、藝文、設計、心理、溝通、資料分析等工作坊供台大師生參加，活動訊息皆公告於學院公布欄或粉絲專頁。於報名網址填寫報名資料後，收到報名成功通知即可參加。"
        },
        {
          "title": "我想玩專案",
          "content": "<p>學院每年將依預算編列狀況，挑選補助由台大學生所提出之專案，專案內容及形式不限，僅主題有以下限制：</p>\n\n<p>1.) 需開放全台大學生報名。</p>\n\n<p>2.) 每次活動需有鼓勵學生勇於嘗試、動手實作之設計。</p>\n\n<p>3.) 需運用設計思考流程提出規劃方案或洞察。</p>\n\n<p>4.) 要好玩。</p>\n\n<p>參考題目：</p>\n\n<p>1.)&nbsp;創新設計解決生活問題</p>\n\n<p>2.) Mini Challenge學院挑戰賽 ex.全能學院改造王、辦公室椅大賽等</p>\n\n<p>無繳件期限，隨到隨審，企劃書來信寄至：raxliu@ntu.edu.tw</p>"
        },
        {
          "title": "我要用實作中心",
          "content": "<p>台大師生於實作中心開放時間持證件至學院登記即可使用。(週一、週四及週五09:00至16:30，不含例假日及學院課程、活動使用時間)。使用流程請參閱「<a href=\"http://dschool.ntu.edu.tw/space/index\" target=\"_self\">實作中心開放要點<img alt=\"\" src=\"/assets/image/download.png\" style=\"width: 19px; height: 17px;\"></a>」。<br>\n有任何相關疑問，請Email至NTUds.irc@gmail.com，或於開放時間撥打(02)3366-1869轉分機55388。</p>"
        }
      ]
    }
  }
}

// var result = Array.from(document.querySelectorAll(".panel")).map(o=>{
//    var title = o.querySelector("[data-toggle='collapse']")
   
//    var content = o.querySelector(".panel-body")
//     return {title:title.innerHTML.trim().split("</i>")[1],content:content.innerHTML.trim()}

// })

</script>

<style>

</style>
