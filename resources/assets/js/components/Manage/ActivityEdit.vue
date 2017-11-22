<template lang="pug">
  .manage_event_edit(v-if="event")
    .container
      .row
        .col-sm-12
          ol.breadcrumb
            li.breadcrumb-item 
              router-link(to="/activity") 管理活動
            li.breadcrumb-item.active 活動編輯
        
          h2(v-if="event_id") 編輯活動- {{ strip_tags(event.title) }}
            button.btn.btn-danger.pull-right(@click="deleteActivity") 刪除活動
            button.btn.btn-primary.pull-right(@click="updateActivity") 儲存更新
          h2(v-else) 新增活動- {{ strip_tags(event.title) }}
            button.btn.btn-primary.pull-right(@click="updateActivity") 儲存活動
          hr

        .col-sm-4
          .panel.panel-primary
            .panel-heading 基本資訊
            .panel-body
              .form-group
                .row
                  labal.col-sm-3 類型
                  .col-sm-9
                    select.form-control(v-model="event.type")
                      option(v-for="op in activityTypeOptions", :value="op.value") {{op.tag}}
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 標題
                  .col-sm-9
                    input.form-control(v-model="event.title")
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 地點
                  .col-sm-9
                    input.form-control(v-model="event.place")
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 時間
                  .col-sm-9
                    //- input.form-control(v-model="event.time")
                    datePicker(v-model="event.time", name="event_time", :config="{format: 'YYYY-MM-DD HH:mm:ss',useCurrent: true}")
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 顯示<br>時間
                  .col-sm-9
                    input.form-control(v-model="event.time_detail")
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 封面
                  .col-sm-9
                    input.form-control(v-model="event.cover")
                    img(:src="event.cover", style="width: 100%")
                    default_pic_selector(@select_pic="select_pic")
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 報名開始
                  .col-sm-9
                    datePicker(v-model="event.open_time", name="event_open_time", :config="{format: 'YYYY-MM-DD HH:mm:ss',useCurrent: true}")
                    //- input.form-control(v-model="event.open_time", placeholder="2017-10-18 00:00:00")
                  br
                  br
              .form-group
                .row
                  labal.col-sm-3 報名結束
                  .col-sm-9
                    datePicker(v-model="event.close_time", name="event_close_time", :config="{format: 'YYYY-MM-DD HH:mm:ss',useCurrent: true}")
                    //- input.form-control(v-model="event.close_time", placeholder="2017-10-18 00:00:00")
                  br
                  br
        .col-sm-8
          .button-group
            .btn.btn-default(v-for="p in panellist" @click="panel=p.value", :class="{'btn-primary':panel==p.value}") {{p.label}}
          .panel.panel-default(v-if="panel=='detail'")
            .panel-heading 詳細內容
            .panel-body
              .form-group
                labal.col-sm-3 描述
                .col-sm-9
                  VueEditor.ve(:id ="'description'", v-model="event.description" )
                  br
                  br
              .form-group
                labal.col-sm-3 註冊資訊
                .col-sm-9
                  VueEditor.ve(:id ="'register_info'", v-model="event.register_info")
                  br
                  br
          .panel.panel-default(v-if="panel=='teacher'")
            .panel-heading 師資
            .panel-body
              .form-group(v-for="(teacher,teacherId) in event.teacher", style="margin-top: 10px")
                .row
                  .col-sm-12
                    .container-fluid
                      h4(style="width: 100%") {{teacherId+1}}. {{teacher.name}}
                        .btn.btn-danger.pull-right(@click="event.teacher.splice(teacherId,1)") 刪除
                      .row.form-group
                        .col-sm-2
                          h5 姓名
                        .col-sm-10
                          input.form-control(v-model="teacher.name", placeholder="姓名")
                      .row.form-group
                        .col-sm-2
                          h5 照片
                        .col-sm-10(style="display: flex")
                          .imgs
                            img(:src="teacher.cover" , style="width: 80px")
                          .control(style="width: 100%")
                            input.form-control(v-model="teacher.cover", placeholder="照片網址")
                            default_pic_selector(@select_pic="(obj)=>{event.teacher[teacherId].cover=obj.url}")
                      
                      .row.form-group
                        .col-sm-2
                          h5 描述
                        .col-sm-10
                          VueEditor.ve(:id ="'teacher_description_'+teacherId", v-model="teacher.description")                          
                      .row.form-group
                        .col-sm-2
                          h5 其他
                        .col-sm-10
                          VueEditor.ve(:id ="'teacher_other_'+teacherId", v-model="teacher.other")                  
                      hr
                      br
              .form-group
                .col-sm-12
                  .btn.btn-default.form-control(@click="event.teacher.push({name: '',description:''})") + 新增
                  br
                  br
                  br
                  br
              
          .panel.panel-default(v-if="panel=='album'")
            .panel-heading 相簿
            .panel-body
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
                            input.form-control(v-model="event.album[picid].image" ,placeholder="照片網址")
                            textarea.form-control(v-model="event.album[picid].caption", placeholder="描述")
                      
                      .col-sm-3
                        default_pic_selector(@select_pic="(obj)=>{event.album[picid].image=obj.url}")
                        .btn.btn-danger(@click="event.album.splice(picid,1)") 刪除
                      .col-sm-12
                        hr
                  .col-sm-12
                    .btn.btn-primary(@click="event.album.push({image:'',caption:''})") 新增照片

          .panel.panel-default(v-if="panel=='qa'")
            .panel-heading 問答
            .panel-body
              .form-group
                .row
                  .col-sm-12
                    label 問題
                  .col-sm-12
                    .form-group(v-for="(qa,qaid) in event.question", v-if="typeof qa=='object'", :name="'qa'+qaid")
                      .form-group(v-if="qa")
                        .row
                          .col-sm-3
                            label {{qaid+1}}. {{qa.question}}
                          .col-sm-9
                            input.form-control(v-model="qa.question")
                        .row
                          .col-sm-3
                            label 類型
                          .col-sm-9
                            select.form-control(v-model="qa.type")
                              option(value="short") 簡答
                              option(value="long") 詳答
                              option(value="select") 選擇
                        .row(v-if="qa.type=='select'")
                          .col-sm-3
                            label 選項(以/隔開)
                          .col-sm-9
                            input.form-control(v-model="qa.options", placeholder="素/葷")
                        .row
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
                      .btn.btn-primary.form-control(@click="addQuestion") 新增問題
            br
            br
          
</template>

<script>
// import axios from 'axios'
import default_pic_selector from '../default_pic_selector.vue'
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
import Vue from 'Vue'
import datePicker from 'vue-bootstrap-datetimepicker'
import QuestionRow from '../Question/QuestionRow'

export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      panel: "detail",
      panellist: [
        {label: "詳細資訊",value:"detail"},
        {label: "相簿",value:"album"},
        {label: "師資",value:"teacher"},
        {label: "表單問答",value:"qa"}
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
        alert("儲存完成！")
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
    QuestionRow
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>

</style>
