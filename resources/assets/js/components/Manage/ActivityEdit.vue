<template lang="pug">
  div.page_event_register(v-if="event")
    .container
      .row
        .col-sm-12
          ol.breadcrumb
            li.breadcrumb-item 
              router-link(to="/activity") 管理活動
            li.breadcrumb-item.active 活動編輯
          h2 編輯活動- {{ strip_tags(event.title) }}
            button.btn.btn-primary.pull-right(@click="updateActivity") 儲存更新
          hr
        .col-sm-6
          .form-group(v-for="key in ['type','title','description']")
          
            labal.col-sm-3 {{transform_key(key)}}
            .col-sm-9
              VueEditor.ve(:id ="key", v-model="event[key]", v-if="key=='register_info' || key=='description'")
              input.form-control(v-model="event[key]" v-else-if="key!='type'")
              select(v-else,v-model="event['type']")
                option(v-for="op in activityTypeOptions" :value="op.value") {{op.tag}}
            br
            br
        .col-sm-6
          .form-group(v-for="key in ['place','time_detail','register_info','cover']")
          
            labal.col-sm-3 {{transform_key(key)}}
            .col-sm-9
              VueEditor.ve(:id ="key", v-model="event[key]", v-if="key=='register_info' || key=='description'")
              input.form-control(v-model="event[key]" v-else)
            br
            br
          
</template>

<script>
// import axios from 'axios'
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
import Vue from 'Vue'
export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      event: {},
      activityTypeOptions: [
        {tag:'工作坊',value:'workshop'},
        {tag:'學院活動',value:'activity'},
      ]
    }
  },
  mounted(){
    let _this = this
    axios.get(`/api/activity/${this.event_id}`).then(res=>{
      Vue.set(_this,"event",res.data)
      _this.event.cover=JSON.parse(_this.event.cover)
      _this.event.teacher=JSON.parse(_this.event.teacher)
      _this.event.album=JSON.parse(_this.event.album)
    })
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
      let send_rows = ['title','type','description','place','register_info','time_detail','cover'];
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
        this.event.cover=JSON.parse(this.event.cover)
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
    }
  },
  components:{
    VueEditor
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>

</style>
