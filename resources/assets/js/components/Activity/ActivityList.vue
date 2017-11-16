<template lang="pug">
  .container
    .row
      .mcol-sm-12
        .panel.panel-default
          .panel-heading 
            h2 學院活動清單
              router-link.btn.btn-primary.pull-right(v-if="user && user.admingroup=='root'",
                                          to="/manage/activity/new") + 新增活動
              .btn.btn-default.pull-right(v-if="order", @click="order=!order") 新 → 舊
              .btn.btn-default.pull-right(v-else, @click="order=!order") 舊 → 新

            
          .panel-body
            .monthGroup(v-for="monthSet in chunkedList")
              h3 {{monthSet.time}}月
              ul
                li(v-for="activity in monthSet.events")
                  ActivityInfoRow(:event_id="activity.id", :key="activity.id")
              

</template>

<script>
import {mapState} from 'vuex'
import ActivityInfoRow from './ActivityInfoRow'
import _ from 'lodash'
export default {
    data(){
      return {
        order: true
      }
    },
    mounted() {
        console.log('Component mounted.')
       
    },
    computed:{
      ...mapState(['user','activities']),
      OrderedList(){
        let result = this.activities.slice().sort((a,b)=>new Date(a.time)>new Date(b.time) )
        
        if (this.order){
          result=result.reverse()
        }
        console.log(result.map(o=>o.time))
        return result
      },
      chunkedList(){
        //依照年分跟月份分群
        let result =  _.groupBy(
          this.OrderedList,event=>
            (new Date(event.time )).getFullYear()*100+(new Date(event.time )).getMonth()
        )

        //轉換成陣列進行排序
        let resultArray = []
        Object.keys(result)
          .forEach(key => {
            console.log(key)
            resultArray.push( {
            'time':key, 
            'events':result[key]
            })
        })
        if (this.order){
          resultArray=resultArray.reverse()
        }
        return resultArray
      }
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
