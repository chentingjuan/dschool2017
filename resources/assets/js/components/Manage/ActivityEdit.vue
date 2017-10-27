<template lang="pug">
  div.page_event_register(v-if="event")
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
                labal.col-sm-3 類型
                .col-sm-9
                  select.form-control(v-model="event.type")
                    option(v-for="op in activityTypeOptions", :value="op.value") {{op.tag}}
                br
                br
              .form-group
                labal.col-sm-3 標題
                .col-sm-9
                  input.form-control(v-model="event.title")
                br
                br
              .form-group
                labal.col-sm-3 地點
                .col-sm-9
                  input.form-control(v-model="event.place")
                br
                br
              .form-group
                labal.col-sm-3 時間
                .col-sm-9
                  input.form-control(v-model="event.time")
                br
                br
              .form-group
                labal.col-sm-3 顯示<br>時間
                .col-sm-9
                  input.form-control(v-model="event.time_detail")
                br
                br
              .form-group
                labal.col-sm-3 封面
                .col-sm-9
                  input.form-control(v-model="event.cover")
                  img(:src="event.cover", style="width: 100%")
                  default_pic_selector(@select_pic="select_pic")
                br
                br
        .col-sm-8
          .panel.panel-default
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
              .form-group
                labal.col-sm-3 師資
                .col-sm-9
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

            br
            br
          
</template>

<script>
// import axios from 'axios'
import default_pic_selector from '../default_pic_selector.vue'
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
import Vue from 'Vue'
export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      event: {
        type: "activity",
        title: "",
        description: "",
        place: "",
        teacher: [],
        time_detail: "",
        register_info: "",
        cover: "",
        album: []
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

      let send_rows = ['title','type','description','place','register_info','album','time','time_detail','cover','teacher'];
      let send_data = {}
      send_rows
        .forEach(function(key) {
          send_data[key]=(typeof ori_data[key] == "object"?JSON.stringify(ori_data[key]):ori_data[key])
      });
      return send_data
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
        this.event = res.data
        // this.event.cover=JSON.parse(this.event.cover)
        this.event.teacher=JSON.parse(this.event.teacher)
        this.event.album=JSON.parse(this.event.album)
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
    }
  },
  components:{
    VueEditor , default_pic_selector
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>

</style>
