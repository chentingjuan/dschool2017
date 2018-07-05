<template lang="pug">
  .page.manage.manage_event_edit(v-if="event")
    .container
      .row
        .col-sm-12
          el-breadcrumb(separator="/")
            el-breadcrumb-item(to="/manage/activity") 管理活動
            el-breadcrumb-item 活動報名
            
          div(v-if="registUserList")
          
            h3.mt-5.mb-5 {{ strip_tags(event.title) }} 清單 (共{{registUserList.length}}筆報名)
            router-link.btn.btn-primary(:to="`/manage/activity/${event.id}`") 編輯回信
            label.mr-2.ml-3 預覽回信: 
            label.mr-4 {{confirm_status}}
            .btn-group
              .btn.btn.outline.grey(@click="previewMail('yes')") 錄取
              .btn.btn.outline.grey(@click="previewMail('pending')") 備取
              .btn.btn.outline.grey(@click="previewMail('no')") 不錄取
            simplert(:useRadius="true"
                :useIcon="false"
                ref="simplert")
            span 
              span.ml-3 顯示問題回答
              el-switch(v-model="showQ")
            //el-table(:data="registUserList")
              el-table-column(prop="serial", label="序號", width=50)
              el-table-column(prop="name", label="名字", width=100)
              el-table-column(prop="department", label="學校單位", width=140)
              el-table-column(prop="phone", label="電話")
              el-table-column(prop="email", label="信箱")
              el-table-column(prop="status", label="狀態", width=100)
              el-table-column(prop="confirm", label="錄取", width=100)
              el-table-column(prop="time", label="報名時間")
              

            vue_lazy_table.mt-5(:table_data="registUserList",
                      :rows="tableRows",
                      :btns="event_btns")


</template>

<script>
import {mapState} from 'vuex'
import vue_lazy_table from '../Data/vue_lazy_table'
import Simplert from 'vue2-simplert'
import _ from "lodash"

export default {
    data() {
      return {
        lists: [],
        event: {
        },
        showQ: true,
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
          "id -> __hide",
          "serial -> 序號",
          "name -> 名字",
          "student_id -> 學號",
          "department -> 學校單位",
          "phone -> 電話",
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
        axios.get(`/api/activity/list/${this.event_id}`,{
          params: {

            token: this.auth.token
          }
        }).then((res)=>{
          Vue.set(this,"lists",res.data);
        })
    },
    computed:{
      ...mapState(['user','auth']),
      filteredTableRows(){
        return this.tableRows
      },
      registUserList(){
        return this.lists.map((d,i)=>{
          let temp={}
          let formdata=(JSON.parse(d.formdata) || []).forEach((o,oid)=>{
            temp['q'+oid]=o.answer            
          })
          console.log(formdata)
          let confirm_type_obj= this.get_event_confirm_type_translate(d.confirm_type)
          let confirm_type_text= `${confirm_type_obj.label+confirm_type_obj.symbol}`
          let result= {
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
            
          }
          if (this.showQ){
            Object.assign(result,temp)
          }

          return result
        })
      },
      confirm_status(){
        let _this = this
        let result= _.groupBy(this.lists || [],(obj)=>(obj.confirm_type) || "尚未確認" )
                     
        let resulttext="";
        // console.log(Object.keys(result))
        Object.keys(result).forEach(key=>{
          console.log(_this.get_event_confirm_type_translate(key))
          if (key){
            resulttext += _this.get_event_confirm_type_translate(key).status + ": "+ result[key].length+ "  / "
          }
        })
        return resulttext
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
          this.$confirm("確認取消報名核可嗎?").then(()=>{
            axios.post(`/api/activity/record/${record.record_id}/confirm/cancel`,{

              token: this.auth.token
            }).then((res)=>{
              //使用傳回的資料更新該筆報名
              Object.assign(recordObj,res.data.record)
              this.$message.success("已取消該筆報名確認")
              // let obj = {
              //   message: "已取消該筆報名確認",
              //   type: 'info'
              // }
              // this.$refs.simplert.openSimplert(obj)
            })
          })
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
          
          this.$confirm("確認「"+action_label+"」該筆報名並寄信通知嗎?").then(()=>{
            axios.post(`/api/activity/record/${record.record_id}/confirm/${action}`,{

              token: this.auth.token
            }).then((res)=>{
              //使用傳回的資料更新該筆報名
              Object.assign(recordObj,res.data.record)
              this.$message.success("已"+action_label+"該筆報名")
            })

          })

        }
      },
      previewMail(type){
        axios.get(`/api/activity/${this.event.id}/mail/${type}`,{
          
          params: {
            token: this.auth.token
          }
        }).then((res)=>{
          //預覽寄出信的內容
          // Object.assign(recordObj,res.data.record)
          // this.$message.success(res.data)
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
