<template lang="pug">
  .container
    .row
      .mcol-sm-12
        .panel.panel-default
          .panel-heading 
            h2 管理我的活動
          .panel-body(v-if="user")
            h4
              | 你已經報名：
            ul(v-if="registedActivityList")
              li(v-for="activity in registedActivityList")
                ActivityInfoRow(:event_id="activity.activity_id")
          .panel-body(v-if="!user")
            h2 登入後可以管理自己的活動


</template>

<script>
import {mapState} from 'vuex'
import ActivityInfoRow from './Activity/ActivityInfoRow'
export default {
    data(){
      return {
        registedActivityList: []
      }
    },
    mounted() {
        console.log('Component mounted.')
        axios.get("/api/user/activity").then(res=>{
          this.registedActivityList=res.data
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
