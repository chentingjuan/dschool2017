<template lang="pug">
.container
  .row
    .col-sm-12
      br
    .col-sm-12
      el-breadcrumb(separator="/")
        el-breadcrumb-item(to="/question") 管理問題
        el-breadcrumb-item 問題編輯
      br
  .row
    .col-sm-5
      el-form
        el-input(v-model="key", placeholder="輸入關鍵字搜尋...")
        el-table(:data="questions", @row-click="handleRowClick", max-height="700")
          el-table-column(prop="id", label="#", width="40", :sortable="true")
          el-table-column(prop="title", label="問題", :sortable="true")
          //- el-table-column(prop="cover",label="封面", width="120")
            //- template(slot-scope="scope")
            //-   h5 {{scope}}
            //-   img.cover(:src="scope.row")
          el-table-column(label="操作", width="180")
            template(slot-scope="scope")
              el-button(size="mini",@click="handleEdit(scope.$index, scope.row)") 編輯
              el-button(size="mini",type="danger",@click="handleDelete(scope.$index, scope.row)") 刪除
      br
      el-button(@click="addNewQuestion", type="primary") 新增問題
    .col-sm-7
      div(v-if="question", v-for="question in [question]", :key="question.id")
        h3 {{question.id}}. {{question.title}}
          div.pull-right
            el-button(@click="handleSave(question)") 儲存更新
            el-button(@click="handleDelete(question.id,question)",type="danger") 刪除
        br
        hr
        el-form(label-width= "80px")
          el-form-item(label="問題")
            el-input(v-model="question.title")
          el-form-item(label="回答")
            VueEditor.ve(:id ="'qacontent'", v-model="question.content",
                  :key="question.id",
                  :useCustomImageHandler="true",
                  @imageAdded="handleImageAdded" ,
                  height="350px" )
      div(v-else)
        h4 點選問題編輯
</template>

<script>
import { VueEditor } from 'vue2-editor'
import {mapState} from 'vuex'
export default {
  data(){
    return {
      question: null,
      creating: false
    }
  },
  computed: {
    ...mapState(['questions'])
  },
  methods: {
    handleDelete(index,row){
// console.log(row)
      this.$confirm("你確定要刪除嗎？").then(()=>{
        axios.post(`/api/question/${row.id}`,{
          _method: 'DELETE',
          // _token: this.csrf_token,
          dataType: 'JSON',
        }).then((res)=>{
  
          this.$message.success("刪除完成")
          this.$store.dispatch("loadQuestions")
          // this.$router.push('/activity')
        })

      })
    },
    handleEdit(index,row){
      this.question=row
    },
    handleSave(question){
      console.log("儲存")
      axios.patch("/api/question/"+question.id,question).then(()=>{
        this.$message.success("儲存成功!")
        this.$store.dispatch("loadQuestions")
      })
    },
    addNewQuestion(){
      axios.post(`/api/question/`,{title:"新問題"}).then((res)=>{
        this.question=res.data
        this.$store.dispatch("loadQuestions")
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
