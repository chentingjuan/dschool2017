<template lang="pug">
  .page.pageActivityList.manage_post
    section.sectionHero
      .container
        .row
          .col-sm-12
            h2 學院新聞清單
            br
        .row

          .col-sm-12
            ol.breadcrumb
              li.breadcrumb-item 
                router-link(to="/news") 管理新聞
              li.breadcrumb-item.active 新聞清單
          
            //- h2(v-if="event_id") 編輯活動- {{ strip_tags(event.title) }}
            //-   button.btn.btn-danger.pull-right(@click="deleteActivity") 刪除活動
            //-   button.btn.btn-primary.pull-right(@click="updateActivity") 儲存更新
            //- h2(v-else) 新增活動- {{ strip_tags(event.title) }}
            //-   button.btn.btn-primary.pull-right(@click="updateActivity") 儲存活動
            //- hr

        .row
          .col-sm-12
            router-link.btn.btn-primary.pull-right(v-if="user && user.admingroup=='root'",
                                        to="/manage/post/new") + 新增新聞
            .btn.btn-default(v-if="order", @click="order=!order") 新 → 舊
            .btn.btn-default(v-else, @click="order=!order") 舊 → 新
            

          .col-sm-12
            //.monthGroup(v-for="monthSet in chunkedList")
            //h3 {{monthSet.time.slice(0,4)+' '+monthSet.time.slice(4)}}月
            vue_lazy_table(:table_data="OrderedList",
                     :rows="tableRows",
                     :btns="btns")
            //ul.list-group
              li.list-group-item(v-for="post in OrderedList", style="background-color: transparent")
                router-link(:to="'/manage/post/'+post.id")
                  h4 {{post.title}} 
                    span.pull-right {{post.date}}
                //ActivityInfoRow(:event_id="activity.id", :key="activity.id")
              

</template>

<script>
import {mapState} from 'vuex'
import vue_lazy_table from '../Data/vue_lazy_table'
//import ActivityInfoRow from './ActivityInfoRow'
import _ from 'lodash'
export default {
    
    data(){
      return {
        order: true,
        tableRows: [
          "subtitle -> __hide",
          "description -> __hide",
          "cover -> __hide",
          " -> __hide",
          "tags -> __hide",
          "link -> __hide",
          "content -> __hide",
          "id -> #",
          "title -> 標題",
          "authos -> 作者",
          "cata -> 類別",
          "date -> 顯示日期",
          "show -> 顯示",
          "stick -> 置頂",
          "created_at -> __hide",
          "updated_at -> 更新時間"
        ],
        btns: [
          {
            label: "編輯",
            action: this.editrow,
            class: function(){},
          }
        ]
      }
    },
    mounted() {
        console.log('Component mounted.')
       
    },
    methods: {
      editrow(row){        
        this.$router.push("/manage/post/"+row.id)
      }
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
     
      vue_lazy_table
    
    }
}
</script>


<style lang="sass?indentedSyntax">
</style>
