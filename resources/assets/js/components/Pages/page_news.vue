<template lang="pug">
  .page.page_news
    //section.sectionHero.white
      //- h1 實作中心 D-SCHOOL
      //- img.coverGraphic(src="http://dschool2017.dev/img/GraphicImplementation.svg")
    section.sectionIntro.white
      .container
        ul.list-group
          li.list-group-item.col-sm-5(
            v-for="post in posts",
            v-if="post.show" )
            img(:src="post.cover", style="width: 100%")
            h3 {{ post.title }}
            p {{ post.description }}

</template>

<script>
export default {
  data(){
    return {
      posts: []  
    }
  },
  mounted(){
    axios.get("/api/post").then((res)=>{
      Vue.set(this,"posts",res.data)
    })
  }
}
</script>

<style>

</style>
