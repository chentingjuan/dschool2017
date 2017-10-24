<template lang="pug">
  .container
    .row
      .mcol-sm-12
        .panel.panel-default
          .panel-heading 
            h2 學院活動清單
              router-link.btn.btn-primary.pull-right(v-if="user && user.admingroup=='root'",
                                          to="/manage/activity/new") + 新增活動
          .panel-body
            ul
              li(v-for="activity in ActivityList")
                ActivityInfoRow(:event_id="activity.id")
              

</template>

<script>
import {mapState} from 'vuex'
import ActivityInfoRow from './ActivityInfoRow'
export default {
    data(){
      return {
        ActivityList: []
      }
    },
    mounted() {
        console.log('Component mounted.')
        axios.get("/api/activity").then(res=>{
          // if (typeof res.data == "array"){
          Vue.set(this,"ActivityList",res.data)
          // }
        })
    },
    computed:{
      ...mapState(['user'])
    },
    components:{
      ActivityInfoRow
    }
}
</script>


<style lang="sass?indentedSyntax">
  ul,li
    list-style: none
    padding: 0
    margin: 0
</style>
