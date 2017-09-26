<template lang="pug">
  .container
    .row
      .mcol-sm-12
        .panel.panel-default
          .panel-heading 
          .panel-body
            h2 {{ event.title }} 報名清單
            hr
            h4
            vue_lazy_table(:table_data="registUserList",
                     :rows="tableRows")

</template>

<script>
import {mapState} from 'vuex'
import vue_lazy_table from '../Data/vue_lazy_table'
export default {
    data() {
      return {
        lists: [],
        event: {},
        tableRows: [
          "id -> #",
          "tag -> 類別",
          "title -> 標題",
          "cover -> __hide",
          "content -> __hide",
          "created_at -> __hide",
          "updated_at -> __hide",
          "carousel -> __hide",
          "author_link -> __hide",
          "author -> 轉載"
        ]

      }
    },
    props: ['event_id'],
    mounted() {
        //取得活動資訊
        let _this = this
        axios.get(`/api/activity/${this.event_id}`).then(res=>{
          Vue.set(_this,"event",res.data)
          _this.event.cover=JSON.parse(_this.event.cover)
          _this.event.teacher=JSON.parse(_this.event.teacher)
          _this.event.album=JSON.parse(_this.event.album)
        })
        console.log('Component mounted.')
        //取得報名清單
        axios.get(`/api/activity/list/${this.event_id}`).then((res)=>{
          Vue.set(this,"lists",res.data);
        })
    },
    computed:{
      ...mapState(['user']),
      registUserList(){
        return this.lists.map((d,i)=>({
          id: i,
          name: d.user.name,
          school: d.user.school || d.user.company,
          student_id: d.user.student_id,
          phone: d.user.phone,
          email: d.user.email,
          time: d.created_at
        }))
      }
    },
    components:{
      vue_lazy_table
    }
}
</script>


<style lang="sass?indentedSyntax">
  ul,li
    list-style: none
    padding: 0
    margin: 0
</style>
