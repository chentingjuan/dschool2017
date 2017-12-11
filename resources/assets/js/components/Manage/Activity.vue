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
            h2 {{ strip_tags(event.title) }} 清單 (共{{registUserList.length}}筆報名)
            router-link.btn.btn-primary(:to="`/manage/activity/${event.id}`") 編輯回信
            label 預覽回信: 
            .btn-group
              .btn.btn.outline.grey(@click="previewMail('yes')") 錄取
              .btn.btn.outline.grey(@click="previewMail('pending')") 備取
              .btn.btn.outline.grey(@click="previewMail('no')") 不錄取
            simplert(:useRadius="true"
                :useIcon="false"
                ref="simplert")
          .panel-body
            h4
            vue_lazy_table(:table_data="registUserList",
                     :rows="tableRows",
                     :btns="event_btns")


                    //-  :edit="confirmRecord",
                    //-  edit_btn_text="核可/取消核可",

</template>

<script>
import {mapState} from 'vuex'
import vue_lazy_table from '../Data/vue_lazy_table'
import Simplert from 'vue2-simplert'


export default {
    data() {
      return {
        lists: [],
        event: {
        },
        event_btns: [
          {
            label: "錄取",
            action: this.confirmRecordYes,
            class: function(row){
              console.log("row:",row)
              return row.confirm_o=="yes"
            },
            show(row){
              return row.confirm_o==null || row.confirm_o==""
            }
          },{
            label: "備取",
            action: this.confirmRecordPending,
            class: function(row){
              return row.confirm_o=="pending"
            },
            show(row){
              return row.confirm_o==null || row.confirm_o==""
            }
            // class: "btn-warning"
          },{
            label: "不錄取",
            action: this.confirmRecordNo,
            class: function(row){
              return row.confirm_o=="no"
            },
            show(row){
              return row.confirm_o==null || row.confirm_o==""
            }
            // class: "btn-default"
          },{
            label: "取消確認",
            action: this.confirmRecordCancel,
            class: function(){},
            show(row){
              return !(row.confirm_o==null || row.confirm_o=="")
            }
            // class: "btn-default"
          }
        ],
        tableRows: [
          "serial -> 序號",
          "name -> 名字",
          "student_id -> 學號",
          "department -> 學校/單位",
          "phone -> 聯絡電話",
          "email -> 信箱",
          "status -> 狀態",
          "confirm -> 錄取",
          "confirm_o -> __hide",
          "time -> 報名時間",
          "formdata -> 資料",
          "record_id -> __hide",
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
          let confirm_type_obj= this.get_event_confirm_type_translate(d.confirm_type)
          let confirm_type_text= `${confirm_type_obj.label+confirm_type_obj.symbol}`
          return {
            record_id: d.id,
            serial: d.serial ,
            name: d.user.name,
            department: (d.user.school?(d.user.school+"-"+d.user.department):null) || d.user.agency,
            // student_id: d.user.student_id,
            phone: d.user.phone,
            email: d.user.email,
            status: this.get_event_status_translate(d.status).label,
            confirm: confirm_type_text,
            confirm_o: d.confirm_type,
            time: d.created_at,
            ...temp
          }
        })
      }
    },
    components:{
      vue_lazy_table,Simplert
    },
    methods: {
      confirmRecordYes(record){
        this.confirmRecord(record,"yes")
      },
      confirmRecordNo(record){
        this.confirmRecord(record,"no")
      },
      confirmRecordPending(record){
        this.confirmRecord(record,"pending")
      },
      confirmRecordCancel(record){
        this.confirmRecord(record,"cancel")
      },
      confirmRecord(record, action){
        let recordObj = this.lists.find(o=>o.id==record.record_id)
        // console.log(recordObj)

        if (recordObj.status=="CONFIRMED"){
          if (confirm("確認取消報名核可嗎?")){
            axios.post(`/api/activity/record/${record.record_id}/confirm/cancel`).then((res)=>{
              //使用傳回的資料更新該筆報名
              Object.assign(recordObj,res.data.record)
              alert("已取消該筆報名確認")
              // let obj = {
              //   message: "已取消該筆報名確認",
              //   type: 'info'
              // }
              // this.$refs.simplert.openSimplert(obj)
            })
          }
        }else{
          let action_label = "錄取"
          if (action=="yes"){
            action_label = "錄取"
          }else if (action=="pending"){
            action_label = "備取"
          }else if (action=="no"){
            action_label = "不錄取"
          }else if (action=="cancel"){
            action_label = "取消"
          }
          
          if (confirm("確認「"+action_label+"」該筆報名並寄信通知嗎?")){
            axios.post(`/api/activity/record/${record.record_id}/confirm/${action}`).then((res)=>{
              //使用傳回的資料更新該筆報名
              Object.assign(recordObj,res.data.record)
              alert("已"+action_label+"該筆報名")

              // let obj = {
              //   message: "已取消該筆報名確認",
              //   type: 'info'
              // }
              // this.$refs.simplert.openSimplert(obj)
            })

          }

        }
      },
      previewMail(type){
        axios.get(`/api/activity/${this.event.id}/mail/${type}`).then((res)=>{
          //預覽寄出信的內容
          // Object.assign(recordObj,res.data.record)
          // alert(res.data)
          let obj = {
              message: res.data,
              type: 'info'
          }
          this.$refs.simplert.openSimplert(obj)
        })
      }
    }
}
</script>


<style lang="sass?indentedSyntax">
  ul,li
    list-style: none
    padding: 0
    margin: 0
  .simplert__content
    width: calc(100% - 30px) !important
    /* margin: 15px */
    max-width: 700px
    text-align: left
    max-height: 80vh
    overflow-y: scroll
    h1
      margin-top: 0
</style>
