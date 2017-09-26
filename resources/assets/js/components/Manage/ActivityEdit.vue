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
          hr
        .col-sm-6
          .form-group(v-for="(attr,key) in event")
          
            labal.col-sm-3 {{key}}
            .col-sm-9
              input.form-control(v-model="event[key]")
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
    }
  },
  methods:{
    
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>
</style>
