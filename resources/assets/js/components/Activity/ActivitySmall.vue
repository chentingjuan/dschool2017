<template lang="pug">
  div.page_event_register
    .container.section_hero
      .cover(:style="{'background-image':'url('+event.cover[0]+')'}")
      .row(v-if="event")
        .col-sm-6
        .col-sm-6.hero_panel.align-self-center
          .tag.mt-10 {{tagname}}
          h4.mt-10 {{event.time_detail}} @ {{event.place}}
          h1.mb-4.mt-4.mt-10(v-html="event.title")
          p(v-html="event.description")
          .btn.btn-outline-primary.btn-lg(role="button", @click="registerEvent") 我要報名
    .row.section_album
      ul.album
        li.image(v-for="img in event.album" ,:style="{'background-image':`url(${img.image})`}", alt="")
          .caption {{img.caption}}
    .container.pb-4.pt-4
      .row.section_teacher
        .col-sm-12
          h2.mb-4 講師簡介{{event_status}}
          .row(v-for="teacher in event.teacher")
            .col-sm-3.text-left
              img.head
              h4.mb-2.mt-2 {{teacher.name}}
              p {{teacher.description}}
              
            .col-sm-9
              p(v-html="teacher.other")
    .container-fluid.section_register
      .container.pb-4.pt-4
        .row
          .col-sm-12
            h2 活動報名
            p(v-html="event.register_info")    
            .btn.btn-primary.btn-lg(role="button", @click="registerEvent") 報名活動
  
</template>

<script>
import axios from 'axios'
import Vue from 'Vue'
export default {
  data() {
    return {
      event: {},
      event_status: "need login"
    }
  },
  mounted(){
    let _this = this
    axios.get('http://localhost:3000/events/1').then(res=>{
      Vue.set(_this,"event",res.data)
    })
    axios.get(`http://dschool_backend.dev/api/activity/${this.event.id}/status`,{
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
      // window.open(`http://dschool_backend.dev/activity/${this.event.id}/register`)
      axios.get(`http://dschool_backend.dev/api/activity/${this.event.id}/register`,{
        activityId: this.event.id
      }).then(res=>{
        console.log(res.data.status)
        if (res.data.status=="need login"){
          window.open("http://dschool_backend.dev/login")
        }
      })
      
    }
  }
}
</script>

<style lang="sass" scoped>
$span: 8px
.page_event_register
  color: #110041
  
  .btn.primary
    

  h1
    font-size: 48px
    line-height: 70px
    font-weight: bold
  h2
    font-size: 42px
    font-weight: bold
    margin-bottom: 2rem
  h3
    font-size: 32px
    margin-bottom: 2rem
  h4
    font-size: 26px
  h5
    font-size: 22px
  p
    letter-spacing: 1px
    line-height: 1.8em

  .section_hero

    .row
      min-height: 100vh
    .cover
      position: absolute
      width: 60%
      height: 100%
      left: 0
      background-size: cover
      
    .tag
    
    .hero_panel
      background-color: #fff
      padding: $span*3
      box-shadow: 0px 0px 20px rgba(black,0.2)

  .section_album
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
          position: absolute
          left: 10px
          bottom: 10px
          font-size: 16px
          letter-spacing: 1px
          font-weight: 500
          &:before
            content: "#"

  .section_teacher
    .head
      width: 200px
      height: 200px
      border-radius: 50%
      
  .section_register
    padding-top: 50px
    padding-bottom: 50px
    background-color: #110041
    color: white
  </style>
