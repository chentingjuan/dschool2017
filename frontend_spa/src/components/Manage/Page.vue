<template lang="pug">
.page.manage.manage-member
  .container(style="max-width: 1350px")
    .row
      .col-sm-12
        h1 管理頁面
        hr
    .row
      .col-sm-4
        el-table(:data="pages", @row-click="handleRowClick",
                 :row-class-name="tableRowClassName")
          el-table-column(prop="id", width="30")
          el-table-column(prop="name", label="選擇編輯頁面", :sortable="true" v-if="nowCataId!=-1")
          el-table-column(prop="title", label="代號", :sortable="true" v-if="nowCataId!=-1")
        
        el-button.mt-3.w100(@click="savePageData(nowEditingPage)",
                       type="primary") 儲存變更
      .col-sm-8(@keyup="updateJsonEditor", v-show="nowEditingPage")
        #jsoneditor

</template>

<script> 
import axios from 'axios'
export default {
  data(){
    return {
      implement: {},
      pages: [],
      nowEditingPage: null
    }
  },
  methods: {
    updateJsonEditor(){
      this.$set(this.nowEditingPage,"content",this.editor.get())
      console.log("json updated")
    },
    savePageData(page){
      this.$set(this.nowEditingPage,"content",this.editor.get())
      console.log(page)
      let pageClone = JSON.parse(JSON.stringify(page))
      pageClone.content = JSON.stringify(pageClone.content)

      axios.post("/api/page/"+page.title,{
        _method: "PATCH",
        ...pageClone
      }).then((res)=>{
        // this.setEvent(res.data)
        this.$message.success("Save Success!")
      })
    },
    setEditingPage(page){
      this.$set(this,"nowEditingPage",page);
      this.editor.set(this.nowEditingPage.content);
    },
    handleRowClick(row){
      this.setEditingPage(row)
    },
    tableRowClassName({row, rowIndex}) {
      if (row===this.nowEditingPage){
        return "row-active"
      }
    }
  },
  mounted(){
    var container = document.getElementById("jsoneditor");
    this.editor = new JSONEditor(container);
  },
  created(){
    axios.get("/api/page/").then((res)=>{
      this.$set(this,"pages",res.data)
      this.pages.forEach(page=>{
        page.content = page.content ?JSON.parse(page.content):{}
      })
    })
  }

}
</script>

<style lang="sass">
.el-table
  .row-active
    background-color: #ddd !important
</style>
