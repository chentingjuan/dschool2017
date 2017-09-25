import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
const store = new Vuex.Store({
  state: {
    news: [],
    questions: [],
    big_font: false,
    search: false,
    is_ie: false,
    scrollTop: 0,
    products: [
      {
          name: "鴻海三心專案",
          description: "睿田提供國際認證品質之際包檢驗、運送與儲存服務",
          cover: "/img/product/3.jpg",
           programs: []
      },
      {
        name: "企業尊榮專案",
        description: "睿田提供國際認證品質之際包檢驗、運送與儲存服務",
          cover: "/img/product/4.jpg",
        programs: [
          {
            tag: "A",
            name: "健康早鳥組合方案",
            description: "",
            client: ""
          },
          {
            tag: "B",
            name: "資深好鳥組合方案",
            description: "",
            client: ""
          },
          {
            tag: "C",
            name: "父親節方案",
            description: "細胞的健康狀況隨著年紀增長、生活型態、工作壓力而受影響，也就是俗稱的老化現象。老化並不可怕，可怕的是因為老化而衍生出的疾病，例如:神經細胞退化造成的阿茲默症…等。我們無法阻止時間前進、也無法停止老化、但是我們將年輕的細胞凍存，保持細胞狀態在儲存的當下，在未來有需要的時候能有多一項工具可以使用。",
            client: "細胞的健康狀況隨著年紀增長、生活型態、工作壓力而受影響，也就是俗稱的老化現象。老化並不可怕，可怕的是因為老化而衍生出的疾病，例如:神經細胞退化造成的阿茲默症…等。",
            contents: [
              {
                name: "免疫細胞儲存",
                description: "細胞的健康狀況隨著年紀增長、生活型態、工作壓力而受影響，也就是俗稱的老化現象。老化並不可怕，可怕的是因為老化而衍生出的疾病，例如:神經細胞退化造成的阿茲默症…等。我們無法阻止時間前進、也無法停止老化"
              },
              {
                name: "幹細胞儲存",
                description: "細胞的健康狀況隨著年紀增長、生活型態、工作壓力而受影響，也就是俗稱的老化現象。老化並不可怕，可怕的是因為老化而衍生出的疾病，例如:神經細胞退化造成的阿茲默症…等。我們無法阻止時間前進、也無法停止老化"
              },
              {
                name: "健康假期",
                description: ""
              }
            ]
          },
          {
            tag: "D",
            name: "美麗無限方案"
          }
        ]
      },
      {
          name: "海外服務專案",
          description: "睿田提供國際認證品質之際包檢驗、運送與儲存服務",
          cover: "/img/product/5.jpg",
          programs: [],
          
      }
    ],
    product_other: {
      title: "儲存流程與注意事項",
      content: [
        "睿田生技的客服專員將會提供您完整的賁訊與詔絢服務，待您完全了解儲存過程後，將會安排感染性疾病檢查，確認無任何疾病疑慮即會與您簽約、與醫師約診及約定細胞抽取時闐。",
        "細胞抽取當曰大約須要3~6小時，請您務必保留充裕的時闐。細胞抽取無須禁貪亦不適飽食，請穿蓄舒適寬鬆的衣服、放鬆的心情到診所進行細胞儲存服務。",
        "細胞抽取的過程中，我們會安排醫師、醫檢師、客服專員為您提供服務，如有任何不適或需求請隨時提出。",
        "由於您的細胞須經多項檢測，相關的檢驗報告會在細抽取日往後推算六週後寄送，並會有客服專員與您聯繫，解釋報告成果"
      ]
    },
  },
  mutations: {
    increment (state) {
      state.count++;
    },
    setNews(state, news){
      state.news=news;
    },
    setQuestion(state,questions){
      state.questions=questions;
    },
    toggle_size(state){
      state.big_font=!state.big_font;
      console.log("toggle size");
    },
    toggle_search(state){
      state.search=!state.search;
      console.log("toggle search");
    },
    set_is_ie(state, value){
      state.is_ie=value;
    },
    setScrollTop(state,value){
      state.scrollTop=value
    }
  },
  actions: {
    loadWebsite(context){
      $.get("http://www.rapidsuretech.com/api/news").then((res)=>{
        console.log("news loaded (action)");
        context.commit("setNews",res);
      });

    }

  }
})
export default store