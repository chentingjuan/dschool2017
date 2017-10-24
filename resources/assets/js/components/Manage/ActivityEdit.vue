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
            button.btn.btn-primary.pull-right(@click="updateActivity") 儲存更新
          h2(v-else) 新增活動- {{ strip_tags(event.title) }}
            button.btn.btn-primary.pull-right(@click="updateActivity") 儲存更新
          hr
        .col-sm-6
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
            labal.col-sm-3 顯示時間
            .col-sm-9
              input.form-control(v-model="event.time_detail")
            br
            br
          .form-group
            labal.col-sm-3 師資
            .col-sm-9
              .form-group(v-for="(teacher,teacherId) in event.teacher", style="margin-top: 10px")
                .row
                  .col-sm-3
                    label {{teacherId+1}}. {{teacher.name}}
                  .col-sm-9
                    input.form-control(v-model="teacher.name", placeholder="姓名")
                    textarea.form-control(v-model="teacher.description", placeholder="描述")
                    textarea.form-control(v-model="teacher.other", rows="6", placeholder="其他")
              .form-group
                .col-sm-12
                  .btn.btn-default.form-control(@click="event.teacher.push({name: '',description:''})") + 新增
                  br
                  br
                  br
                  br
        .col-sm-6
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
            labal.col-sm-3 封面
            .col-sm-9
              input.form-control(v-model="event.cover")
            .col-sm-3
              default_pic_selector(@select_pic="select_pic")
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
        _this.event.cover = JSON.parse(_this.event.cover.replace(/\\\"/g,"\""))
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

      let send_rows = ['title','type','description','place','register_info','time_detail','cover','teacher'];
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
    }
  },
  components:{
    VueEditor , default_pic_selector
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>

</style>
