<template lang="pug">
  .container
    .row
      .col-sm-12
        ol.breadcrumb
          li.breadcrumb-item 
            router-link(to="/activity") 管理活動
          li.breadcrumb-item.active 報名清單
        .panel.panel-default(v-if="registUserList")
          .panel-heading
            h2 {{ strip_tags(event.title) }} 報名清單 (共{{registUserList.length}}筆報名)
          .panel-body
            h4
            vue_lazy_table(:table_data="registUserList",
                     :rows="tableRows")

</template>

<script>
import {mapState} from 'vuex'
import vue_lazy_table from '../Data/vue_lazy_table'
export default {
    data() {
      return {
        lists: [],
        event: {
        },
        tableRows: [
          "serial -> 報名序號#",
          "name -> 名字",
          "student_id -> 學號",
          "department -> 學校/單位",
          "phone -> 聯絡電話",
          "email -> 信箱",
          "status -> 狀態",
          "time -> 報名時間",
          "formdata -> 資料",
        ]

      }
    },
    props: ['event_id'],
    mounted() {
        //取得活動資訊
        let _this = this
        axios.get(`/api/activity/${this.event_id}`).then(res=>{
          Vue.set(_this,"event",res.data)
          // _this.event.cover=JSON.parse(_this.event.cover)
          _this.event.teacher=JSON.parse(_this.event.teacher)
          _this.event.album=JSON.parse(_this.event.album)
        })
        console.log('Component mounted.')
        //取得報名清單
        axios.get(`/api/activity/list/${this.event_id}`).then((res)=>{
          Vue.set(this,"lists",res.data);
        })
    },
    computed:{
      ...mapState(['user']),
      registUserList(){
        return this.lists.map((d,i)=>{
          let temp={}
          let formdata=(JSON.parse(d.formdata) || []).forEach((o,oid)=>{
            temp['q'+oid]=o.answer            
          })
          console.log(formdata)
          return {
            serial: d.serial ,
            name: d.user.name,
            department: (d.user.school?(d.user.school+"-"+d.user.department):null) || d.user.agency,
            // student_id: d.user.student_id,
            phone: d.user.phone,
            email: d.user.email,
            status: this.get_event_status_translate(d.status),
            time: d.created_at,
            ...temp
          }
        })
      }
    },
    components:{
      vue_lazy_table
    }
}
</script>


<style lang="sass?indentedSyntax">
  ul,li
    list-style: none
    padding: 0
    margin: 0
</style>
