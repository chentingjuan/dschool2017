<template lang="pug">
.page.manage.manage-member
  .container(style="max-width: 1350px")
    .row
      .col-sm-12
        br
      .col-sm-12
        el-breadcrumb(separator="/")
          el-breadcrumb-item(to="/manage/ember") 管理成員
          el-breadcrumb-item 成員編輯
        br
    .row
      .col-sm-6
        .catas
          .sel(v-for="cata in memberCata", 
              :class="{active: nowCataId==cata.id}",
              @click="switchCata(cata)") {{cata.type}} ({{getOrderCount(cata)}})

        hr
        el-form
          el-input(v-model="key", placeholder="輸入關鍵字搜尋...")
          el-table(:data="filtered_data", @row-click="handleRowClick", max-height="700",
                   :default-sort="{prop: 'order_id', order: 'ascending'}" )
            // el-table-column(prop="id", label="#", width="40", :sortable="true")
            el-table-column(prop="order_id", label="#", width="60", :sortable="true")
            el-table-column(prop="name", label="姓名" , width="100", :sortable="true")
            //- el-table-column(prop="cover",label="封面", width="120")
              //- template(slot-scope="scope")
              //-   h5 {{scope}}
              //-   img.cover(:src="scope.row")
            el-table-column(prop="position", label="職位", :sortable="true")
            el-table-column(prop="cataname", label="種類", width="80", :sortable="true")
            el-table-column(prop="orderbtns", label="順序", width="100", :sortable="true" v-if="nowCataId!=-1")
              template(slot-scope="scope")
                .text-center
                  .btn-order.pl-2.pr-2(@click="changeOrder(filtered_data,scope.row,-1)")
                    i.fa.fa-angle-up
                  .btn-order.pl-2.pr-2(@click="changeOrder(filtered_data,scope.row,1)")
                    i.fa.fa-angle-down
                //el-select(v-model="scope.row.order_id", placeholder="-" )
                  el-option(:value="-1" label="-")
                  el-option(v-for="i in getOrderCount(memberCata.find(cata=>cata.id==nowCataId))",
                            :label="i",
                            :value="i")

            el-table-column(label="操作", width="150")
              template(slot-scope="scope")
                // el-button(size="mini",@click="handleEdit(scope.$index, scope.row)") 編輯
                el-button(size="mini",type="danger",@click="handleDelete(scope.$index, scope.row)") 刪除
        br
        el-button(@click="addNewMember", type="primary") 新增成員
      .col-sm-6.col-edit
        div(v-if="editingId!=-1 || creating")
          h3
            span(v-if="editingId!=-1") {{editingId}}. 
            span(v-if="creating") 新增 - 
            span {{member.name}}
            div.pull-right
              el-button(@click="saveMember(member)") 儲存更新
              el-button(@click="handleDelete(member.id,member)",type="danger") 刪除
          br
          el-form(label-width= "80px")
            el-form-item(label="名字")
              el-input(v-model="member.name")
            el-form-item(label="院所/公司")
              el-input(v-model="member.company", width="200")
            el-form-item(label="職位")
              el-input(v-model="member.position", width="200")
            el-form-item(label="照片")
              el-input(v-model="member.cover", placeholder="照片網址")
                default_pic_selector(@select_pic="(obj)=>{member.cover=obj.url}", slot="append")
              div.cover(:style="cssbg(member.cover)", style="width: 80px;height: 80px;background-size: cover;")
            el-form-item(label="種類")
              el-select(v-model="member.cata")
                el-option(v-for="(mc,cid) in memberCata", 
                          :value="mc.id", :label="mc.type",
                          :key="cid")

            el-form-item(label="內容")
              //el-input(v-model="member.content",type="textarea",rows="10")
              VueEditor.ve(:id ="'mailcontent'", v-model="member.content",
                    :useCustomImageHandler="true",
                    @imageAdded="handleImageAdded" ,
                    height="250px" )
        div(v-else) 選擇成員以編輯
          //object-editor(v-model="member", :hidden="['id','order_id','show','created_at','updated_at']")
</template>

<script>
import {mapState} from 'vuex'
import default_pic_selector from '../default_pic_selector.vue'
import { VueEditor } from 'vue2-editor'
import Vue from 'vue'
export default {
  data(){
    return {
      editingId: -1,
      key: "",
      creating: false,
      member: {
        content: "",
      },
      nowCataId: -1,
      memberCata:[
       {
         id: 1,
         eng: "NIN_JA",
         label: "忍者",
         type: "行政團隊",
         img: "/img/about_sectionMembers_staffIcon1.svg"
       },{
         id: 2,
         eng: "SEI_FU",
         label: "師傅!",
         type: "教學團隊",
         img: "/img/about_sectionMembers_staffIcon2.svg"
       },{
         id: 3,
         eng: "NIN_JA",
         label: "徒弟~",
         type: "學生團隊",
         img: "/img/about_sectionMembers_staffIcon3.svg"
       },{
         id: 4,
         eng: "SEI_SHUNG",
         label: "師兄",
         type: "歷屆夥伴",
         img: "/img/about_sectionMembers_staffIcon4.svg"
       }
     ]
    }
  },
  mounted(){
    
  },
  computed: {
    ...mapState(['teammembers']),
    filtered_data(){
      let filtered = this.teammembers.filter(o=> (this.key=="" || o.name.indexOf(this.key)!=-1) )

      if (this.nowCataId!=-1){
        // console.log(filtered)
        filtered = filtered.filter(obj=>obj.cata==this.nowCataId)
      }
      let transformed = filtered.map(o=>{
        let nx = {...o}
        let cata = this.memberCata.find(mc=>mc.id==o.cata)
        nx.cataname = (cata && cata.type) || "-" 
        return nx
      })
      transformed.sort((a,b)=>a.order_id>b.order_id?1:-1)
        .forEach((member,mid)=>{
          member.order_id=mid
        })
      
      this.saveAllMember(transformed,false)
      return transformed
    }
  },
  methods: {
    handleRowClick(row,event,column){
      this.creating=false
      this.editingId=row.id
      this.member=(this.teammembers || []).find(o=>o.id==this.editingId)
      // console.log(row.id)
    },
    handleDelete(index,row){
// console.log(row)
      this.$confirm("你確定要刪除嗎？").then(()=>{
        axios.post(`/api/teammember/${row.id}`,{
          _method: 'DELETE',
          // _token: this.csrf_token,
          dataType: 'JSON',
        }).then((res)=>{
  
          this.$message.success("刪除完成")
          this.$store.dispatch("loadTeammembers")
          // this.$router.push('/activity')
        })

      })
    },
    saveMember(member){
      if (this.creating){
        this.creating=false
        let _this=this
        setTimeout(()=>{
          _this.$store.dispatch("loadTeammembers")
        },800)
        axios.post("/api/teammember/",member).then((res)=>{
          this.$store.dispatch("loadTeammembers")
          this.$message.success("新增成功!")
          let nm = res.data
          console.log("nm",nm)
          this.editingId=nm.id
          this.member=(this.teammembers || []).find(o=>o.id==this.editingId)
          // this.handleRowClick(nm,null,null)
        })
        
      }else{
        // console.log("儲存")
        axios.patch("/api/teammember/"+member.id,member).then(()=>{
          this.$message.success("儲存成功!")

          this.$store.dispatch("loadTeammembers")
        })

      }
    },
    saveAllMember(list,reload){
        axios.post("/api/teammember/updateAll",{members: list}).then((res)=>{
          if (reload!==false){
            this.$store.dispatch("loadTeammembers")
          }
        })
    },
    addNewMember(){
      this.editingId=-1
      this.creating=true
      this.member={content: ""}
    },
    switchCata(cata){
      if (cata.id==this.nowCataId){
        this.nowCataId=-1
      }else{
        this.nowCataId=cata.id
      }
    },
    getOrderCount(cata){
      return this.teammembers.map(t=>t.cata).filter(mid=>mid==cata.id).length
    },
    changeOrder(list,current,delta){
      let orderId = current.order_id
      let target = list.find(obj=>obj.order_id==orderId+delta)
      if (target){
        current.order_id=target.order_id
        target.order_id=orderId
      }
      this.saveAllMember([current,target])
      this.$message.success("更新成功!")
    }
  },
  components: {
    default_pic_selector, 
    VueEditor , 
  }
}
</script>

<style lang="sass">
@import "../../assets/sass/_variables.sass"
@import "../../assets/sass/_mixins.sass"
.manage-member
  .catas
    display: flex
    .sel
      cursor: pointer
      flex: 1
      text-align: center
      padding: 10px
      &.active
        background-color: #999
        color: white
  .btn-order
    background-color: #eee
    margin: 5px
    display: inline-block
    border-radius: 50%
    color: black
    cursor: pointer
    &:hover
      background-color: #ddd
  .el-table__row
    cursor: pointer
</style>
