<template lang="pug">
  .page.pageActivityList.manage_post
    section.sectionHero
      .container
        .row
          .col-sm-12
            h2 學院活動清單
            br
        .row
          .col-sm-12
            router-link.btn.btn-primary.pull-right(v-if="user && user.admingroup=='root'",
                                        to="/manage/post/new") + 新增新聞
            .btn.btn-default(v-if="order", @click="order=!order") 新 → 舊
            .btn.btn-default(v-else, @click="order=!order") 舊 → 新

          .col-sm-12
            //.monthGroup(v-for="monthSet in chunkedList")
            //h3 {{monthSet.time.slice(0,4)+' '+monthSet.time.slice(4)}}月
            ul.list-group
              li.list-group-item(v-for="post in OrderedList", style="background-color: transparent")
                router-link(:to="'/manage/post/'+post.id")
                  h4 {{post.title}} 
                    span.pull-right {{post.date}}
                //ActivityInfoRow(:event_id="activity.id", :key="activity.id")
              

</template>

<script>
import {mapState} from 'vuex'
//import ActivityInfoRow from './ActivityInfoRow'
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
      ...mapState(['user','activities','posts']),
      OrderedList(){
        let result = this.posts.slice().sort((a,b)=>new Date(a.time)>new Date(b.time) )
        
        if (this.order){
          result=result.reverse()
        }
        //console.log(result.map(o=>o.time))
        return result
      },
      chunkedList(){
        //依照年分跟月份分群
        let result =  _.groupBy(
          this.OrderedList,event=>
            (new Date(event.time )).getFullYear()*100+(new Date(event.time )).getMonth()
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
      //ActivityInfoRow
    }
}
</script>


<style lang="sass?indentedSyntax">
</style>
