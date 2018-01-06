<template lang="pug">
  .page.pageActivityList
    section.sectionHero.blue
      img.coverGraphic(src="/img/hero_activity_cover.svg")
            
    section.sectionList.theme.blue
      .container
        .row
          .col-sm-12
            //- h1 學院活動
            
        .row
          .col-sm-12
            router-link.btn.btn-primary.pull-right(v-if="user && user.admingroup=='root'",
                                        to="/manage/activity/new") + 新增活動
            .btn.btn-default(v-if="order", @click="order=!order") 新 → 舊
            .btn.btn-default(v-else, @click="order=!order") 舊 → 新

          .col-sm-12
            .monthGroup(v-for="monthSet in chunkedList")
              h2.month {{monthSet.time.slice(0,4)+' / '+monthSet.time.slice(4)}}月
              ul
                li(v-for="activity in monthSet.events")
                  ActivityInfoRow(
                    :event_id="activity.id", 
                    :key="activity.id",title="查看資訊")
              

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
            (new Date(event.time.replace(/-/g, "/") )).getFullYear()*100+ ((new Date(event.time.replace(/-/g, "/") )).getMonth()+1)
        )
        console.log(result)

        //轉換成陣列進行排序
        let resultArray = []
        let keys = Object.keys(result)
        if (keys){
          keys.forEach(key => {
                  console.log(key)
                  resultArray.push( {
                  'time':key, 
                  'events':result[key]
                  })
          })
          
        }
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
</style>
