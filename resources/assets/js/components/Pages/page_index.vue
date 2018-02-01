<template lang="pug">
.page.pageIndex
  section.sectionHero
    img.logo(src="/img/index__heroTitle.svg")

    .titularBanner
      .main REACTION
      .secondary OF CREATIVITY
    .left
    .line(:class="nowSection")
      .d.d1
        img(src="/img/index__heroCir1.svg")
      .d.d2
        img(src="/img/index__heroCir2.svg")
      .d.d3
        img(src="/img/index__heroCir3.svg")
      .d.d4
        img(src="/img/index__heroCir4.svg")
      .d.d5
        img(src="/img/index__heroCir5.svg")
    .ruler
      .rgroup(v-for="i in 10")
        .tick.tickHead
          //.num {{i}}
        .tick(v-for="o in 4")
    .mouseScroll
      img(src="/img/index__iconMouse.svg")
      img.mouseScrollArrow(src="/img/index__iconArrowDown.svg")
    .content
      h3 創意，是永無止盡探究世界的真實面貌
      hr
    .dots
  section.sectionFirst.theme.blue(style="display: none")
    .container
      .row
        .col-sm-12
          h2 全臺灣第一個虛擬學院<br>創造跨領域教學環境
          hr
          p 在創新創業風氣興盛後，臺大覺察學校創新教育的不足，<br>遂於2014年成立創新設計學院，並於2015年秋季正式授課。

  section.sectionSecond.theme.blue(style="display: none")
    .container
      .row
        .col-sm-4
          img(src="/img/index__iconFeature1.svg")
          h2 D-Act
          h4 Sky is the limit to what the D-Act can offer.
          hr
          p 以不同的形式，不同的議題，創造更多生活化的交流，帶動人潮與溫度的匯聚，沖刷認知的壁壘。並在向前衝刺後留下寶貴的經驗。

        .col-sm-4
          img(src="/img/index__iconFeature2.svg")
          h2 D-Course
          h4 We have no answer, find your own one.
          hr
          p 洞悉真正的問題，才能真的一勞永逸。而這份才能誰也不能給你，請自己來培養吧！


        .col-sm-4
          img(src="/img/index__iconFeature3.svg")
          h2 MakerSpace
          h4 Never Stop Trying
          hr
          p 親自動手實作，驗證設計，大師級的實作技術學習，以手作激發創意，從技藝汲取創新。



  
</template>

<script>
import {mapState} from 'vuex'
import $ from 'jquery'
var PIXI = require('pixi.js');
// var TweenMax = require("gsap/tweenmax")
export default {
  data(){
    return {
      nowSection: ""
    }
  },
  watch: {
    scrollTop(){
      // let wh = $(window).outerHeight()
      // let list = []
      // if (this.scrollTop+wh/2>$(".sectionSecond").offset().top){
      //   list.push("second")
      // }
      // if (this.scrollTop+wh/2>$(".sectionFirst").offset().top){
      //   list.push("first")
      // }
      // this.nowSection=list
    }
  },
  mounted(){

    // var starAnimation = new PIXI.Application(600,600,{antialias: false, transparent: true, resolution: 1})
    // document.querySelector(".d1").appendChild(starAnimation.view);
    // var star1 = new PIXI.Graphics();
    // let cx=starAnimation.renderer.width/2;
    // let cy=starAnimation.renderer.height/2;
    // star1.beginFill(0xFFFFFF);
    // star1.drawCircle(cx,cy,100)
    // star1.endFill();
    // var star2 = new PIXI.Graphics();
    // star2.lineStyle(1, 0xFFFFFF, 0.4);
    // star2.beginFill(0xFFFFFF, 0);
    // star2.drawCircle(cx,cy,200);
    // star2.endFill();

    // let _this = this
    // starAnimation.stage.addChild(star1,star2);
    // starAnimation.ticker.add(function(){
    //   star2.scale=_this.scrollTop/1000
    // })
  },
  computed:{
    ...mapState(['scrollTop'])
  }
}
</script>

<style>

</style>
