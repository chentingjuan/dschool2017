<template lang="pug">
  router-link.rowActivity.row.nolinkstyle.animated.fadeIn(v-if="event",:to="'/activity/'+event_id")
    .col-sm-4.col-img
      .event_img(:style="{'background-image':'url('+event.cover+')'}", alt="")
      .tag.mt-10 {{tagname}}
    .col-sm-8
      h4.mt-10 {{event.time_detail}} @ {{event.place}}
      h3(v-text="event.title.replace('<br>',' ')")
      p.visible-xs(v-html="event.description.slice(0,70)+'...'")
      p.hidden-xs(v-html="event.description")
      hr
      span 狀態: {{get_event_status_translate(event_status).label}} &nbsp;
      //router-link.btn.btn-primary(
        role="button", 
        :to="'/activity/'+event_id") 詳情資訊
      

      //button.btn.btn-secondary.btn-link(
        role="button", 
        @click="cancelEvent",
        v-if="event_status=='registed'") 取消報名
      br.visible-xs

      span(v-if="user && user.admingroup=='root'") 
        br.visible-xs
        span.hidden-xs &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //- span 管理：
        router-link.btn.grey(
          :to="'/manage/activity/'+event_id+'/list'"
          v-if="user && user.admingroup=='root'") 報名清單 ({{event.regist_count}}筆)

        router-link.btn.outline.grey(
          :to="'/manage/activity/'+event_id"
          v-if="user && user.admingroup=='root'") 編輯
          
    </template>

<script>
// import axios from 'axios'
import {mapState} from 'vuex'
import Vue from 'Vue'
export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      event_status: "need login"
    }
  },
  beforeMount(){
    let _this = this
    // this.event=
    // axios.get(`/api/activity/${this.event_id}`).then(res=>{
    //   Vue.set(_this,"event",res.data)
      // _this.event.cover=JSON.parse(_this.event.cover)
    // this.event.teacher=JSON.parse(this.event.teacher)
    // this.event.album=JSON.parse(this.event.album)
    // })
    axios.get(`/activity/${this.event_id}/status`,{
      activityId: this.event_id
    }).then(res=>{
      this.event_status=res.data.status
     
    })
  },
  computed: {
    ...mapState(['user','activities']),
    event(){
      return this.activities.find(act=>act.id==this.event_id)
    },
    tagname(){
      switch(this.event.type){
        case "event":
          return "學院活動"
        case "workshop":
          return "工作坊"
      }
      return "學院活動"
    },
    teacher(){
      if (this.event){
        return JSON.parse(this.event.teacher)
      }
      return []
    },
    album(){
      if (this.event){
        return JSON.parse(this.event.album)
      }
      return []

    }
  },
  methods:{
    translate_status(txt){
      switch( (txt+"").toLocaleLowerCase() ){
        case "unconfirmed":
          return "已報名待確認"
      }
    },
    registerEvent(){
      axios.get(`/activity/${this.event.id}/register`,{
        activityId: this.event.id
      }).then(res=>{
        console.log(res.data.status)
        if (res.data.status=="need login"){
          window.location=`/login`
        }else if (res.data.status=="success"){
          this.event_status="registed"
          alert("報名成功！")
        }else if (res.data.status=="repeated"){
          this.event_status="registed"
          alert("你已報名囉！")
        }
      })
      
    },
    cancelEvent(){

      if (confirm("確認要取消報名嗎？")){
        axios.get(`/activity/${this.event.id}/cancel`,{
          activityId: this.event.id
        }).then(res=>{
          console.log(res.data.result)
          if (res.data.result=="need login"){
            window.location=`/login`
          }else if (res.data.result=="success"){
            this.event_status=res.data.cancel?"not registed":"need login"
            alert("取消成功！")
            
          }
        })
      }else{
        
      }
    },
    registOrCancelEvent(){
      (this.event_status!='registed'?this.registerEvent:this.cancelEvent)()
    }
  }
}
</script>


<style lang="sass?indentedSyntax" scoped>

</style>
