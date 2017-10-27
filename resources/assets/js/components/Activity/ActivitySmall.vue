<template lang="pug">
  div.page_event_register(v-if="event")
    .container.section_hero
      transition(name="fade-delay")
        .cover(
          v-if="event",
          :style="{'background-image':'url('+event.cover+')'}")
      .row(v-if="event")
        .col-sm-6
        .col-sm-6.hero_panel.align-self-center
          .tag.mt-10 {{tagname}}
          h4.mt-10 {{event.time_detail}} @ {{event.place}}
          h1.mb-4.mt-4.mt-10(v-html="event.title")
          p(v-html="event.description")
          br
          br
          p 狀態：{{get_event_status_translate(event_status)}}
          button.btn.btn-primary(
            role="button", 
            @click="registerEvent") {{(event_status=="UNCONFIRMED" || event_status=="REGISTED")?"你已經報名囉！":"我要報名"}}
          button.btn.btn-secondary.btn-link(
            role="button", 
            @click="cancelEvent",
            v-if="(event_status=='UNCONFIRMED' || event_status=='REGISTED')") 取消報名
    .row.section_album
    .row.section_album
      ul.album
        li.image(v-for="img in event.album" ,:style="{'background-image':`url(${img.image})`}", alt="")
          .caption {{img.caption}}
    .container.pb-4.pt-4
      .row.section_teacher
        .col-sm-12
          h2.mb-4 講師簡介
          .row(v-for="teacher in event.teacher")
            .col-sm-3.text-left
              .head(:style="{backgroundImage: `url(${teacher.cover})`}")
              h4.mb-2.mt-2 {{teacher.name}}
              p(v-html="teacher.description")
              
            .col-sm-9
              p(v-html="teacher.other")
    .container-fluid.section_register
      .container.p-b-4.p-t-4
        .row
          .col-sm-12
            h2 活動報名
            p(v-html="event.register_info")    
            br
            .btn.btn-primary(
              role="button", 
              @click="registOrCancelEvent") {{(event_status=="UNCONFIRMED" || event_status=="REGISTED")?"取消報名":"我要報名"}}
  
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
      event: null,
      event_status: "need login"
    }
  },
  mounted(){
    let _this = this
    axios.get(`/api/activity/${this.event_id}`).then(res=>{
      Vue.set(_this,"event",res.data)
      // _this.event.cover=JSON.parse(_this.event.cover)
      _this.event.teacher=JSON.parse(_this.event.teacher)
      _this.event.album=JSON.parse(_this.event.album)
    })
    axios.get(`/activity/${this.event_id}/status`,{
      activityId: this.event_id
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
          this.event_status=res.data.record.status
          alert("已完成報名登記，將以E-mail寄發活動錄取通知。並請詳閱活動注意事項。")
        }else if (res.data.status=="repeated"){
          // this.event_status=res.data.record.status
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
      }
    },
    registOrCancelEvent(){
      (!(this.event_status=='registed' || this.event_status!='UNCONFIRMED')?this.registerEvent:this.cancelEvent)()
    }
  }
}
</script>

<style lang="sass?indentedSyntax"  scoped>


$span: 8px 
.page_event_register
  color: #110041



  .btn.primary
    

  h1
    font-size: 46px
    line-height: 70px
    font-weight: bold
  h2
    font-size: 42px
    font-weight: bold
    margin-bottom: 5rem
  h3
    font-size: 32px
    margin-bottom: 2rem
  h4
    font-size: 26px
  h5
    font-size: 22px
  p
    font-size: 16px
    letter-spacing: 1px
    line-height: 1.9em

  .section_hero
    .tag
      display: inline-block
      background-color: #ff5559
      color: white
      padding: 10px 40px
      position: absolute
      left: -10px
      top: 10px
      box-shadow: 0px 0px 20px rgba(black,0.1)
    .row
      min-height: 100vh

      &>*
        vertical-align: middle

    .cover
      position: absolute
      width: 60%
      height: 100%
      left: 0
      background-size: cover
      
    .tag
    
    .hero_panel
      margin-top: 20vh
      background-color: #fff
      padding: $span*3
      padding-top: $span*8
      box-shadow: 0px 0px 20px rgba(black,0.2)

  .section_album
    margin-top: 50px
    .album
      display: flex
      padding-left: 0
      .image
        min-height: 400px
        width: 35vw
        background-size: cover
        background-position: center center
        position: relative
        list-style: none
        margin: 10px
        box-shadow: 0px 0px 20px rgba(black,0.2)
        &:nth-of-type(1)
          margin-left: 0
        &:before
          content: ""
          display: block
          position: absolute
          width: 100%
          height: 100%
          background: linear-gradient(180deg,#{rgba(black,0)} 70%,#{rgba(black,0.5)} 100%)
        .caption
          color: white
          left: 10px
          position: absolute
          bottom: 10px
          font-size: 16px
          letter-spacing: 1px
          font-weight: 500
          &:before
            content: "#"

  .section_teacher
    padding-top: 50px
    padding-bottom: 50px
    .head
      width: 200px
      height: 200px
      border-radius: 50%
      background-size: cover
      
  .section_register
    padding-top: 50px
    padding-bottom: 50px
    background-color: #110041
    color: white
</style>
