<template lang="pug">
  router-link.rowActivity.row.nolinkstyle.animated.fadeIn(v-if="event",:to="'/activity/'+event_id")
    .col-sm-4.col-img
      .event_img(:style="{'background-image':'url('+event.cover+')'}", alt="")
      .tag.mt-10 {{tagname}}
    .col-sm-8
      h4.mt-10 {{event.time_detail}} @ {{event.place}}
      h3(v-text="event.title.replace('<br>',' ')")
      p.visible-xs(v-html="getSummary(event.description,70)")
      p.hidden-xs(v-html="getSummary(event.description,100)")
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
import Vue from 'Vue'
import {mapState} from 'vuex'
export default {
  props: [
    "event_id"
  ],
  data() {
    return {
      event: (this.events || []).find(o=>o.id==this.event_id),
      event_status: "need login",
      event_status_obj: {"status" : "need login"}
    }
  },
  mounted(){
    this.loadEvent()
  },
  computed: {
    ...mapState(['events','auth']),
    tagname(){
      if (this.event){
        switch(this.event.type){
          case "event":
            return "學院活動"
          case "workshop":
            return "工作坊"
        }
        return "學院活動"

      }
    },
    user(){
      return this.auth.user
    }
  },
  methods:{
    getSummary(text,length){
      text = text || ""
      length= length || 100
      if (text.length>length){
        return text.slice(0,length)+"..."
      }else{
        return text
      }
    },
    loadEvent(){

      let _this = this
      this.setEvent( (this.events || []).find(o=>o.id==this.event_id))
      axios.get(`/api/activity/${this.event_id}`).then(res=>{
        this.setEvent(res.data)
      })
      
      axios.get(`/api/activity/${this.event_id}/status`,{
        params: {
          token: this.auth.token,
          activityId: this.event_id
        }
      }).then(res=>{
        this.event_status = res.data.status
        this.event_status_obj = res.data
      }).catch(()=>{
        this.event_status = "need login"

      })
    },
    setEvent(event){
        // _this.event.cover=JSON.parse(_this.event.cover)
        if (event){
          Vue.set(this,"event",event)
          this.event.teacher=JSON.parse(this.event.teacher)
          this.event.album=JSON.parse(this.event.album)
          this.event.question=JSON.parse(this.event.question)
          this.event.question.forEach((qid,index)=>{
            axios.get(`/api/question/${qid}`).then(res=>{
              Vue.set(this.event.question,index,res.data)
            });
          })

        }
    },
    registerEvent(){
      if (this.event.question && this.event.question.some(qa=>qa.require && !qa.answer)){
        alert("請填寫報名相關必要資訊！")
      }else{
        axios.post(`/api/activity/${this.event.id}/register`,{
          token: this.auth.token,
          activityId: this.event.id,
          formdata: JSON.stringify(this.event.question.map(qa=>({id: qa.id,answer: qa.answer})))
        }).then(res=>{
          console.log(res.data.status)
          if (res.data.status=="need login"){
            window.location=`/login`
          }else if (res.data.status=="success"){
            this.event_status=res.data.record.status
            this.$message("已完成報名登記，將以E-mail寄發活動錄取通知。並請詳閱活動注意事項。")
          }else if (res.data.status=="repeated"){
            // this.event_status=res.data.record.status
            this.$message("你已報名囉！")
            
          }
        })

      }
      
    },
    cancelEvent(){
      this.$confirm("確認要取消報名嗎？").then(()=>{
        axios.post(`/api/activity/${this.event.id}/cancel`,{
          token: this.auth.token,
          activityId: this.event.id
        }).then(res=>{
          console.log(res.data.result)
          if (res.data.result=="need login"){
            window.location=`/login`
          }else if (res.data.result=="success"){
            this.event_status="not registed"
            this.$message("取消成功！")
            
          }
        })
      })
    },
    registOrCancelEvent(){
      (!(this.event_status=='registed' || this.event_status!='UNCONFIRMED')?this.registerEvent:this.cancelEvent)()
    }
  },
  watch: {
    user(){
      console.log('user change')
      this.loadEvent()
    }
  }
}
</script>



<style lang="sass?indentedSyntax" scoped>

</style>
