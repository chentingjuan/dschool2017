<template lang="pug">
  .manage_event_edit(v-if="event")
    simplert(:useRadius="true"
      :useIcon="false"
      ref="simplert")
    el-container.container
      el-header
        el-breadcrumb(separator="/")
          el-breadcrumb-item(to="/activity") 管理活動
          el-breadcrumb-item 活動編輯
      el-header
        h3(v-if="event_id") 編輯活動- {{ strip_tags(event.title) }}
          el-button.pull-right(round type="danger" @click="deleteActivity") 刪除活動
          el-button.pull-right(round type="primary" @click="updateActivity") 儲存更新
          router-link(:to="`/event/${event_id}`")
            el-button.pull-right(round) 前往頁面
        h3(v-else) 新增活動- {{ strip_tags(event.title) }}
          el-button.pull-right(round type="primary" @click="updateActivity") 儲存更新
        br
        br
      el-container
        el-main
          el-tabs(v-model="panel" )
            el-tab-pane(v-for="p in panellist" ,
                          :label="p.label",
                          :name="p.value")
          el-form(v-if="panel=='detail'", label-width="100px")
            el-form-item(label="描述")
              VueEditor.ve(:id ="'description'", v-model="event.description",
                :useCustomImageHandler="true",
                @imageAdded="handleImageAdded"  )
            el-form-item(label="註冊資訊")
              VueEditor.ve(:id ="'register_info'", v-model="event.register_info",
                :useCustomImageHandler="true",
                @imageAdded="handleImageAdded" )
          
          el-form.panel-body(v-if="panel=='main'" label-width="60px")
            el-form-item(label="類型")
              el-select(v-model="event.type")
                el-option(v-for="op in activityTypeOptions", :value="op.value" , :label="op.tag")
            el-form-item(label="標題")
              el-input(v-model="event.title")
            el-form-item(label="地點")
              el-input(v-model="event.place")
            el-form-item(label="時間")
              el-date-picker(
                v-model="event.time",
                type="datetime",
                placeholder="活動時間",
                value-format="yyyy-MM-dd HH:mm:ss")
            el-form-item(label="顯示")
              el-input(v-model="event.time_detail" , placeholder="顯示時間(例: 106/11/12、14)")
            el-form-item(label="封面")
              el-input(v-model="event.cover")
              img(:src="event.cover", style="width: 100%;max-width: 100px")
              default_pic_selector(@select_pic="select_pic")
            el-form-item(label="報名")
              el-date-picker(
                v-model="event.open_time",
                type="datetime",
                placeholder="報名開始時間",
                value-format="yyyy-MM-dd HH:mm:ss")
            el-form-item
              el-date-picker(
                v-model="event.close_time",
                type="datetime",
                placeholder="報名結束時間",
                value-format="yyyy-MM-dd HH:mm:ss")
          el-form(v-if="panel=='teacher'")
            div(v-for="(teacher,teacherId) in event.teacher", style="margin-top: 10px")
              h4(style="width: 100%") {{teacherId+1}}. {{teacher.name}}
                .btn.btn-danger.pull-right(@click="event.teacher.splice(teacherId,1)") 刪除
              
              .container-fluid
                .row.form-group
                  .col-sm-2
                    h5 姓名
                  .col-sm-10
                    el-form-item
                      el-input(v-model="teacher.name", placeholder="姓名")
                .row.form-group
                  .col-sm-2
                    h5 照片
                  .col-sm-10(style="display: flex")
                    .imgs
                      img(:src="teacher.cover" , style="width: 80px")
                    .control(style="width: 100%")
                      el-input(v-model="teacher.cover", placeholder="照片網址")
                      default_pic_selector(@select_pic="(obj)=>{event.teacher[teacherId].cover=obj.url}")
                
                .row.form-group
                  .col-sm-2
                    h5 描述
                  .col-sm-10
                    VueEditor.ve(:id ="'teacher_description_'+teacherId", v-model="teacher.description",
                        :useCustomImageHandler="true",
                        @imageAdded="handleImageAdded" )                          
                .row.form-group
                  .col-sm-2
                    h5 其他
                  .col-sm-10
                    VueEditor.ve(:id ="'teacher_other_'+teacherId", v-model="teacher.other",
                        :useCustomImageHandler="true",
                        @imageAdded="handleImageAdded" )                  
                hr
                br
            .form-group
              .col-sm-12
                .btn.btn-default.form-control(@click="event.teacher.push({name: '',description:''})") + 新增

              
          el-form(v-if="panel=='album'")
            .form-group
              .row
                .col-sm-12
                  label 相簿
                .col-sm-12(v-for="(pic,picid) in event.album")
                  .row
                    .col-sm-9
                      .row
                        .col-sm-3
                          img(:src="pic.image", style="width: 100%")
                        .col-sm-9
                          el-input(v-model="event.album[picid].image" ,placeholder="照片網址")
                          textarea.form-control(v-model="event.album[picid].caption", placeholder="描述")
                    
                    .col-sm-3
                      default_pic_selector(@select_pic="(obj)=>{event.album[picid].image=obj.url}")
                      .btn.btn-danger(@click="event.album.splice(picid,1)") 刪除
                    .col-sm-12
                      hr
                .col-sm-12
                  el-button(rounded @click="event.album.push({image:'',caption:''})") 新增照片

          el-form(v-if="panel=='qa'")
            .row
              .col-sm-12
                .form-group(v-for="(qa,qaid) in event.question", v-if="typeof qa=='object'", :name="'qa'+qaid")
                  .form-group(v-if="qa")
                    el-form-input.row
                      .col-sm-3
                        label {{qaid+1}}. {{qa.question}}
                      .col-sm-9
                        el-input(v-model="qa.question")
                    el-form-input.row
                      .col-sm-3
                        label 類型
                      .col-sm-9
                        el-select(v-model="qa.type")
                          el-option(value="short", label="簡答") 
                          el-option(value="long", label="詳答") 
                          el-option(value="select", label="選擇") 
                    el-form-input.row(v-if="qa.type=='select'")
                      .col-sm-3
                        label 選項(以/隔開)
                      .col-sm-9
                        el-input(v-model="qa.options", placeholder="素/葷")
                    el-form-input.row
                      .col-sm-3
                        label 必填
                      .col-sm-9
                        .button-group
                          .btn.btn-default(@click="qa.require=0", :class="{'btn-primary': !qa.require}") 非必填
                          .btn.btn-default(@click="qa.require=1", :class="{'btn-primary': qa.require}") 必填
                    .btn.btn-danger(@click="removeQuestion(qa.id)") 移除問題
                .form-group
                  hr
                  br
                  el-button.form-control(@click="addQuestion") 新增問題

          el-form(v-if="panel=='email'")
            .form-group
              labal.col-sm-3 提醒事項
              .col-sm-9
                VueEditor.ve(:id ="'mailcontent'", v-model="event.mailcontent",
                  :useCustomImageHandler="true",
                  @imageAdded="handleImageAdded"  )
                br
                br
            .form-group
              labal.col-sm-3 結束回覆日期
              .col-sm-9
                el-input(v-model="event.end_response_date",
                                    placeholder="結束回覆日期 (11/2 星期x)")
</template>

<script>
// import axios from 'axios'
import default_pic_selector from '../default_pic_selector.vue'
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
import Vue from 'Vue'
import datePicker from 'vue-bootstrap-datetimepicker'
import QuestionRow from '../Question/QuestionRow'
import Simplert from 'vue2-simplert'

export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      panel: "main",
      panellist: [
        {label: "活動設定",value:"main"},
        {label: "詳細資訊",value:"detail"},
        {label: "相簿",value:"album"},
        {label: "師資",value:"teacher"},
        {label: "表單問答",value:"qa"},
        {label: "信件資料",value:"email"}
      ],
      event: {
        type: "activity",
        title: "",
        description: "",
        place: "",
        teacher: [],
        time_detail: "",
        register_info: "",
        cover: "",
        album: [],
        question: [],
        open_time: (new Date()).toISOString().substring(0, 10)+" 00:00:00",
        close_time: (new Date()).toISOString().substring(0, 10)+" 00:00:00"
      },
      activityTypeOptions: [
        {tag:'工作坊',value:'workshop'},
        {tag:'學院活動',value:'activity'},
      ]
    }
  },
  mounted(){
    let _this = this
    if (this.event_id){

      axios.get(`/api/activity/${this.event_id}`).then(res=>{

        Vue.set(_this,"event",res.data)
        // console.log(_this.event.cover)
        _this.event.teacher = JSON.parse(_this.event.teacher.replace(/\\\"/g,"\""))
        // _this.event.cover = JSON.parse(_this.event.cover.replace(/\\\"/g,"\""))
        _this.event.album = JSON.parse(_this.event.album.replace(/\\\"/g,"\""))
        _this.event.question = JSON.parse(_this.event.question.replace(/\\\"/g,"\""))
        _this.event.question =_this.event.question.filter(o=>o)
        if (_this.event.question==null){
          _this.event.question=[]
        }

        _this.event.question.forEach((qid,index)=>{
          axios.get(`/api/question/${qid}`).then(res=>{
            Vue.set(_this.event.question,index,res.data)
          });
        })

      })

    }
  },
  computed: {
    tagname(){
      switch(this.event.type){
        case "event":
          return "學院活動"
        case "workshop":
          return "工作坊"
      }
      return "學院活動"
    },
    dataForSend(){
      let ori_data  = JSON.parse(JSON.stringify(this.event))
      
      // ori_data.cover=JSON.stringify(ori_data.cover)
      ori_data.teacher=JSON.stringify(ori_data.teacher)
      ori_data.album=JSON.stringify(ori_data.album)

      // let send_rows = ['title','type','description','place','register_info','album','time','time_detail','cover','teacher'];
      // let send_data = {}
      // send_rows
      //   .forEach(function(key) {
      //     send_data[key]=(typeof ori_data[key] == "object"?JSON.stringify(ori_data[key]):ori_data[key])
      // });
      return ori_data
    },
    ...mapState(['csrf_token'])
  }, 
  methods:{
    updateActivity(){
      axios.post(`/api/activity/${this.event.id}`,{
        _method: 'PATCH',
        _token: this.csrf_token,
        dataType: 'JSON',
        ...this.dataForSend
      }).then((res)=>{
        // alert("儲存完成！")
        let obj = {
          message: "儲存完成！",
          type: 'info'
        }
        this.$refs.simplert.openSimplert(obj)
        // this.event = res.data
        // // this.event.cover=JSON.parse(this.event.cover)
        // this.event.teacher=JSON.parse(this.event.teacher)
        // this.event.album=JSON.parse(this.event.album)
        // this.event.question=JSON.parse(this.event.question)
      })
    },
    transform_key(key){
      let list = [
        "type | 類型",
        "title | 標題",
        "description | 描述",
        "place | 地點",
        "time_detail | 時間資訊",
        "register_info | 報名資訊",
        "cover | 封面"
      ]
      let result = list.map(s=>s.split(" | ") ).find(o=>o[0]==key)
      return result?result[1]:key
    },
    select_pic(obj){
      console.log(obj)
      this.event.cover=obj.url
    },
    deleteActivity(){
      if (confirm('確認要刪除這個活動嗎？')){
        axios.post(`/api/activity/${this.event.id}`,{
          _method: 'DELETE',
          _token: this.csrf_token,
          dataType: 'JSON',
        }).then((res)=>{
          alert("刪除完成！")
          this.$router.push('/activity')
        })
      }
    },
    addQuestion(){
      if (!Array.isArray(this.event.question)){
        this.event.question=[];
      }
      axios.post(`/api/question`,{
        _method: 'POST',
        _token: this.csrf_token
      }).then((res)=>{
        let nq = res.data
        nq.type="short"
        nq.answer=""
        nq.question=""
        nq.options=null
        nq.require=1
        Vue.set(this.event.question,this.event.question.length,nq)
      })
    },
    removeQuestion(qid){
      if (confirm("你確定要移除這個問題嗎？(已上線活動的回覆資料將被刪除)")){
        axios.post(`/api/question/${qid}`,{
          _method: 'DELETE',
          _token: this.csrf_token
        }).then((res)=>{
          this.event.question=this.event.question.filter(o=>o.id!=qid)
          this.$forceUpdate();
        })

      }
      
    }
  },
  components:{
    VueEditor , 
    default_pic_selector, 
    datePicker,
    QuestionRow,
    Simplert
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>

</style>
