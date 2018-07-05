<template lang="pug">
  .page.manage
    .container
      .row
        .col-sm-12
          el-breadcrumb(separator="/")
            el-breadcrumb-item(to="/manage/user") 使用者
      .row
        .col-sm-12
          div(v-if="UserList")
            h2.mb-4 使用者清單 (共{{UserList.length}}筆資料)
            vue_lazy_table(:table_data="UserList",
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
          "uuid -> __hide",
          "name -> 名字",
          "type -> 種類",
          "created_at -> 註冊時間",
          "updated_at -> __hide",
          "verified -> 驗證",
          "student_id -> 學號",
          "school -> 學校",
          "department -> 系級",
          "agency -> 單位",
          "phone -> 聯絡電話",
          "email -> 信箱",
          "status -> 狀態",
          "time -> 報名時間",
          "admingroup -> 權限",
        ]

      }
    },
    props: ['event_id'],
    mounted() {

        //取得報名清單
        axios.get(`/api/user/list`,{
          params:{
            token: this.auth.token
          }
        }).then((res)=>{
          Vue.set(this,"lists",res.data);
        })
    },
    computed:{
      ...mapState(['user','auth']),
      UserList(){
        let r = JSON.parse(JSON.stringify(this.lists))
        r.forEach(user=>user.created_at = user.created_at.split(' ')[0])
        return r
      }
    },
    components:{
      vue_lazy_table
    }
}
</script>


<style lang="sass">
  ul,li
    list-style: none
    padding: 0
    margin: 0
</style>
