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
                     :rows="tableRows",
                     :edit="confirmRecord",
                     edit_btn_text="核可/取消核可")

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
          "record_id -> __hide"
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
            record_id: d.id,
            serial: d.serial ,
            name: d.user.name,
            department: (d.user.school?(d.user.school+"-"+d.user.department):null) || d.user.agency,
            // student_id: d.user.student_id,
            phone: d.user.phone,
            email: d.user.email,
            status: this.get_event_status_translate(d.status).label,
            time: d.created_at,
            ...temp
          }
        })
      }
    },
    components:{
      vue_lazy_table
    },
    methods: {
      confirmRecord(record){
        let recordObj = this.lists.find(o=>o.id==record.record_id)
        // console.log(recordObj)

        if (recordObj.status=="CONFIRMED"){
          if (confirm("確認取消報名核可嗎?")){
            axios.post(`/api/activity/record/${record.record_id}/confirm`).then((res)=>{
              //使用傳回的資料更新該筆報名
              Object.assign(recordObj,res.data.record)
              alert("已取消該筆報名確認")
            })
          }
        }else{
          if (confirm("確認報名並寄信通知嗎?(測試中，將不會寄信)")){
            axios.post(`/api/activity/record/${record.record_id}/confirm`).then((res)=>{
              //使用傳回的資料更新該筆報名
              Object.assign(recordObj,res.data.record)
              alert("已確認該筆報名")
            })

          }

        }
      }
    }
}
</script>


<style lang="sass?indentedSyntax">
  ul,li
    list-style: none
    padding: 0
    margin: 0
</style>
