<template lang="pug">
.container-fluid.manage-layout
  .row
    .col-sm-3.col-md-2.col-manage
      h3.title.mb-5 管理
      //- pre {{routesManage}}
      router-link.nav-item(:to="'/manage/'+route.path",
                  v-for="route in routesManage",
                  v-if="route.meta.mainNav") {{route.meta.title}}
      router-link.btn.trans-white.w100.mt-5(to="/") 返回主網頁
    .col-sm-3.col-md-2
    .col-sm-9.col-md-10
      .pt-3.mt-md-3(v-if="is_admin")
        router-view
      .pt-3(v-else)
        h3.text-center 請先登入!

      
</template>

<script>
import routesManage from '@/router/routes_manage'
import {mapState,mapMutations,mapActions} from 'vuex'

// console.log(routesManage.children)
export default {
  data(){
    return {
      routesManage: routesManage.children
    }
  },
  computed: {
    ...mapState({
      user: state=>state.auth.user,
      scrollTop: 'scrollTop'
    }),
    is_admin(){
      return this.user && this.user.admingroup=='root' 
    }
  }
}
</script>

<style lang="sass">
@import "../../assets/sass/_mixins.sass"

.manage-layout
  .col-manage
    background-color: #222
    min-height: 100vh
    padding-top: 120px
    padding-left: 0
    padding-right: 0
    // padding-left: 15px
    // padding-right: 15px
    color: white
    position: fixed
    z-index: 1000
    .title
      position: absolute
      left: 100px
      top: 25px
      font-size: 20px
    .nav-item
      display: block
      width: 100%
      padding: 20px
      text-align: center
      // border-top: solid 1px rgba(white,0.3)
      border-bottom: solid 1px rgba(white,0.15)
      color: white
      font-size: 17px
      +trans
      letter-spacing: 2px
      &.router-link-active
        background-color: #555
      &:hover
        background-color: #333
        text-decoration: none
        



</style>
