<template lang="pug">
  div.page_event_register(v-if="event")
    .container.section_hero
      .cover.animated.fadeIn(
        v-if="event",
        :style="cssbg(event.maincover || event.cover)")
      .row
        .col-sm-6
        .col-sm-6.panel.hero_panel.align-self-center
          .tag.mt-10 {{tagname}}
          h4.mt-10 {{event.time_detail}} @ {{event.place}}
          h1.mb-4.mt-4.mt-10(v-html="event.title")
          p(v-html="event.description")
          .buttons(v-if="get_event_status_translate(event_status).open")
            button.btn.btn-primary(
              role="button", 
              @click="scrollTo('.section_register')") {{(get_event_status_translate(event_status).registed)?"你已經報名囉！":"我要報名"}}
              span ({{get_event_status_translate(event_status).label + get_event_confirm_type_translate(event_status_obj.type).label }})
            button.btn.btn-default.btn-link(
              role="button", 
              @click="cancelEvent",
              v-if="get_event_status_translate(event_status).registed") 取消報名 
    .row.section_about
      .col-sm-12
        .panel.theme.white
          .row
            .col-sm-6
              h2 活動介紹
              hr
              div(v-html="event.content || event.description")

    .row.section_album
      ul.album
        li.image(v-for="img in event.album" ,:style="{'background-image':`url(${img.image})`}", alt="")
          .caption {{img.caption}}
    .container
      .row.section_teacher.theme.blue
        .col-sm-12
          h4 Speakers
          h2 講師簡介
          .row(v-for="teacher in event.teacher")
            .col-sm-3.text-left
              .head
                .img(:style="{backgroundImage: `url(${teacher.cover})`}")
              
            .col-sm-9
              h4.teacher_name {{teacher.name}}
              p.teacher_description(v-html="teacher.description")
              p(v-html="teacher.other")

    .container-fluid.section_register.theme.white
      .container
        .row
          .col-sm-4
            h2 活動報名
            p 
              span 狀態：{{get_event_status_translate(event_status).label + get_event_confirm_type_translate(event_status_obj.type).label}}
            p 開放報名時間: {{event.open_time}}~{{event.close_time}}
            p(v-html="event.register_info")    
          .col-sm-8
            div(v-if="get_event_status_translate(event_status).open && !get_event_status_translate(event_status).registed")
              h4 報名資訊
              br
              .form-group(v-for="(qa,qaid) in event.question")
                label {{qaid+1}}. {{qa.question}}:
                input.form-control(v-model="qa.answer", v-if="qa.type=='short'")
                textarea.form-control(v-model="qa.answer", v-if="qa.type=='long'", rows="5")
                select.form-control(v-model="qa.answer", v-if="qa.type=='select'")
                  option(v-for="op in qa.options.split('/')" ,:value="op") {{op}}
            div.panel_timeout(v-else)
              img.img-timeout(src="/img/activity_timeout.svg")

            br
            div(v-if="get_event_status_translate(event_status).open")
              button.btn.btn-primary(
                role="button", 
                @click="registerEvent") {{(get_event_status_translate(event_status).registed)?"你已經報名囉！":"我要報名"}}
              button.btn.secondary.opacity(
                role="button", 
                @click="cancelEvent",
                v-if="get_event_status_translate(event_status).registed") 取消報名

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
