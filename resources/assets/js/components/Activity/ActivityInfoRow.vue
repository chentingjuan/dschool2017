<template lang="pug">
  div.row(v-if="event")
    .col-sm-4
      .event_img(:style="{'background-image':'url('+event.cover[0]+')'}", alt="")
      .tag.mt-10 {{tagname}}
    .col-sm-8
      h4.mt-10 {{event.time_detail}} @ {{event.place}}
      h3(v-text="event.title.replace('<br>',' ')")
      p.visible-xs(v-html="event.description.slice(0,70)+'...'")
      p.hidden-xs(v-html="event.description")
      hr

      router-link.btn.btn-primary(
        role="button", 
        :to="'/activity/'+event_id") 詳情資訊

      button.btn.btn-secondary.btn-link(
        role="button", 
        @click="cancelEvent",
        v-if="event_status=='registed'") 取消報名
        
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
      event: {},
      event_status: "need login"
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
    axios.get(`/activity/${this.event.id}/status`,{
      activityId: this.event.id
    }).then(res=>{
      this.event_status=res.data.status
     
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

.row
  border-bottom: solid 1px rgba(black,0.2)
  padding: 10px 0px
.event_img
  width: 100%
  height: 280px
  background-size: cover

.tag
  position: absolute
  top: 0px
  right: 0
  background-color: #f95356
  color: white
  padding: 5px 10px

</style>
