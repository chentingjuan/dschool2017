<template lang="pug">
  div.page_event_register(v-if="event")
    .container
      .row
        .col-sm-12
          br
          br
          br
          br
          h2 編輯活動{{ event.title }}
          button.btn.btn-primary.pull-right(@click="updateActivity") 儲存更新
          hr
        .col-sm-6
          .form-group(v-for="key in ['type','title','description']")
          
            labal.col-sm-3 {{transform_key(key)}}
            .col-sm-9
              textarea.form-control(rows=10,v-model="event[key]", v-if="key=='register_info' || key=='title'|| key=='description'")
              input.form-control(v-model="event[key]" v-else)
            br
        .col-sm-6
          .form-group(v-for="key in ['place','time_detail','register_info','cover']")
          
            labal.col-sm-3 {{transform_key(key)}}
            .col-sm-9
              textarea.form-control(rows=10, v-model="event[key]", v-if="key=='register_info' || key=='title'|| key=='description'")
              input.form-control(v-model="event[key]" v-else)
            br
          
</template>

<script>
// import axios from 'axios'
import Vue from 'Vue'
export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      event: {}
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
      let result  = JSON.parse(JSON.stringify(this.event))
      Object.keys(result).forEach(function(key,index) {
          result[key]=(typeof result[key] == "object"?JSON.stringify(result[key]):result[key])
      });
      return result
    }
  },
  methods:{
    updateActivity(){
      axios.post(`/api/activity/${this.event.id}`,{
        _method: 'put',
        ...this.dataForSend
      }).then(()=>{
        alert("儲存完成！")
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
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>
</style>
