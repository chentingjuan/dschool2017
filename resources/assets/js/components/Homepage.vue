<template lang="pug">
  .container
    .row
      .col-md-10.col-md-offset-1
        .panel.panel-default
          .panel-heading Example Component
          .panel-body
            h2 報名活動管理
            hr
            h4
              | 你已經報名：
            ul
              li
                ActivityInfoRow(event_id="1")

</template>

<script>
import {mapState} from 'vuex'
import ActivityInfoRow from './Activity/ActivityInfoRow'
export default {
    mounted() {
        console.log('Component mounted.')
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
