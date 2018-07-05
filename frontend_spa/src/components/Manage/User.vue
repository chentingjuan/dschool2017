<template lang="pug">
  .page.manage
    .container
      .row
        .col-sm-12
          el-breadcrumb(separator="/")
            el-breadcrumb-item(to="/manage/user") 使用者
      .row
        .col-sm-12
          div(v-if="userList")
            h2.mb-4 使用者清單 (共{{userList.length}}筆資料)
            .row
              .col-sm-6
                el-input(v-model="keyword" placeholder="搜尋會員")
              .col-sm-6
                vue_lazy_table.float-right(:table_data="userList",
                       :rows="tableRows",
                       :hide_table="true")
            el-table(:data="userList").mt-4
              el-table-column(prop="id", label="#" width="50"  fixed="left", :sortable="true")
              el-table-column(prop="name", label="姓名" fixed="left")
              el-table-column(prop="type", label="種類" fixed="left")
                template(slot-scope="scope")
                  span {{ scope.row.type=="student"?"學生":"一般"}}
              el-table-column(prop="school", label="學校 / 單位" width="120" fixed="left", :sortable="true")
                template(slot-scope="scope")
                  span {{ scope.row.school || scope.row.agency}}

              el-table-column(prop="department", label="系級" width="120", :sortable="true")

              el-table-column(prop="phone", label="電話" width="120", :sortable="true")
              el-table-column(prop="email", label="信箱" width="250")
              // el-table-column(prop="company", label="單位")
              el-table-column(prop="student_id", label="學號", :sortable="true")
              el-table-column(prop="admingroup", label="權限" width="80", :sortable="true")
              el-table-column(prop="created_at", label="註冊時間" width="100", :sortable="true")
              el-table-column(prop="verified", label="驗證" width="80", :sortable="true")
                template(slot-scope="scope")
                  span {{ scope.row.verified?"✓":"☓" }}

</template>

<script>
import {mapState} from 'vuex'
import vue_lazy_table from '../Data/vue_lazy_table'
export default {
    data() {
      return {
        lists: [],
        event: {},
        keyword: "",
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
      userList(){
        let r = JSON.parse(JSON.stringify(this.lists))
        r.forEach(user=>user.created_at = user.created_at.split(' ')[0])
        return r.filter(user=> (this.keyword=="" || JSON.stringify(user).indexOf(this.keyword)!=-1))
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
