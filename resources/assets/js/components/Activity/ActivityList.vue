<template lang="pug">
  .container
    .row
      .mcol-sm-12
        .panel.panel-default
          .panel-heading Example Component
          .panel-body
            h2 學院活動
            hr
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
          this.ActivityList=res.data
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
