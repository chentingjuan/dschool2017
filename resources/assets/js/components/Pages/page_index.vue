<template lang="pug">
.page.pageIndex
  section.sectionHero
    img.logo(src="/img/index__heroTitle.svg")
    .line
      img.d1(src="/img/index__heroCir1.svg")
      img.d2(src="/img/index__heroCir2.svg")
      img.d3(src="/img/index__heroCir3.svg")
      img.d4(src="/img/index__heroCir4.svg")
      img.d5(src="/img/index__heroCir5.svg")
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
</template>

<script>
export default {

}
</script>

<style>

</style>
