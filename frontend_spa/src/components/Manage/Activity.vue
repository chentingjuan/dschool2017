<template lang="pug">
.container
  .row
    .col-sm-12
      br
    .col-sm-12
      el-breadcrumb(separator="/")
        el-breadcrumb-item(to="/manage/activity") 管理活動
        el-breadcrumb-item {{$route.meta.title}}
      br
  .row
    .col-sm-12
      el-table(:data="activities",  :default-sort="{prop: 'time', order: 'descending'}")
        el-table-column(prop="id" label="#" ,width=60 :sortable="true")
        el-table-column(prop="cover" label="封面" ,width=150)
          template(slot-scope="scope")
            img(width=150 :src="scope.row.cover") 
        el-table-column(prop="title" label="標題"  :sortable="true")
        el-table-column(prop="type" label="種類" width=100, :sortable="true")
        el-table-column(prop="time" label="時間" width=100, :sortable="true" )
          template(slot-scope="scope")
            span {{ (scope.row.time || "").split(" ")[0] }}
        el-table-column(prop="mode" label="狀態" width=120, :sortable="true")
        el-table-column(prop="regist_count" label="報名人數" width=100, :sortable="true")
        el-table-column(prop="manage" label="管理功能" ,width=260,)
          template(slot-scope="scope")
            router-link.btn.lightGrey(:to="'/manage/activity/'+scope.row.id") 編輯
            router-link.btn.lightGrey(:to="'/manage/activity/'+scope.row.id+'/list'") 報名清單
    // pre {{activities[0]}}
</template>

<script>
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
export default {
  data(){
    return {
      question: null,
      creating: false,
    }
  },
  computed: {
    ...mapState(['activities','auth'])
  },
  methods: {
    handleDelete(index,row){
// console.log(row)
      this.$confirm("你確定要刪除嗎？").then(()=>{
        axios.post(`/api/qainfo/${row.id}`,{
          _method: 'DELETE',
          token: this.auth.token,
          // _token: this.csrf_token,
          dataType: 'JSON',
        }).then((res)=>{
  
          this.$message.success("刪除完成")
          this.$store.dispatch("loadQAinfos")
          // this.$router.push('/activity')
        })

      })
    },
    handleEdit(index,row){
      this.question=row
    },
    handleSave(question){
      console.log("儲存")
      axios.patch("/api/qainfo/"+question.id,question, {
        token: this.auth.token,
      }).then(()=>{
        this.$message.success("儲存成功!")
        this.$store.dispatch("loadQAinfos")
      })
    },
    addNewQuestion(){
      axios.post(`/api/qainfo/`,{
        title:"新問題",
        token: this.auth.token,
      }).then((res)=>{
        this.question=res.data
        this.$store.dispatch("loadQAinfos")
        // this.$router.push('/activity')
      })
    }
  },
  components: {
    VueEditor , 
  }
}
</script>

<style>

</style>
