<template lang="pug">
.page.manage.manage-member
  .container(style="max-width: 1350px")
    .row
      .col-sm-12
        br
      .col-sm-12
        el-breadcrumb(separator="/")
          el-breadcrumb-item(to="/manage/ember") 管理課程
          el-breadcrumb-item 課程編輯
        br
    .row
      .col-sm-6
        .catas
          .sel(v-for="cata in catas", 
              :class="{active: nowCataId==cata.id}",
              @click="switchCata(cata)") {{cata.title}} ({{getOrderCount(cata)}})

        hr
        el-form
          el-input(v-model="key", placeholder="輸入關鍵字搜尋...")
          el-table(:data="filtered_data", @row-click="handleRowClick", max-height="700",
                   :default-sort="{prop: 'order_id', order: 'ascending'}" )
            // el-table-column(prop="id", label="#", width="40", :sortable="true")
            // el-table-column(prop="order_id", label="#", width="60", :sortable="true" v-if="nowCataId==-1")
            
            el-table-column(prop="title", label="名稱" , width="150", :sortable="true")
            el-table-column(prop="type", label="種類", width="120", :sortable="true")
            el-table-column(prop="code", label="編號" , width="90", :sortable="true")
            el-table-column(prop="orderbtns", label="順序", width="100", :sortable="true" v-if="nowCataId==-1")
              template(slot-scope="scope")
                .text-center
                  .btn-order.pl-2.pr-2(@click="changeOrder(filtered_data,scope.row,-1)")
                    i.fa.fa-angle-up
                  .btn-order.pl-2.pr-2(@click="changeOrder(filtered_data,scope.row,1)")
                    i.fa.fa-angle-down
                //el-select(v-model="scope.row.order_id", placeholder="-" )
                  el-option(:value="-1" label="-")
                  el-option(v-for="i in getOrderCount(courseCata.find(cata=>cata.id==nowCataId))",
                            :label="i",
                            :value="i")

            el-table-column(label="操作", width="150")
              template(slot-scope="scope")
                el-button(size="mini",type="danger",@click="handleDelete(scope.$index, scope.row)") 刪除
        br
        el-button(@click="addNewCourse", type="primary") 新增課程
      .col-sm-6.col-edit
        div(v-if="editingId!=-1 || creating")
          h3(v-if="course")
            span(v-if="editingId!=-1") {{editingId}}. 
            span(v-if="creating") 新增 - 
            span {{course.title}}
            div.pull-right
              el-button(@click="saveCourse(course)") 儲存更新
              el-button(@click="handleDelete(course.id,course)",type="danger") 刪除
          br
          el-form(label-width= "80px")
            el-form-item(label="標題")
              el-input(v-model="course.title")
            el-form-item(label="當期")
              el-checkbox(v-model="course.current")
            el-form-item(label="類型")
              el-select(v-model="course.type")
                el-option(v-for="cata in catas",
                          :label="cata.title",
                          :value="cata.title")

            el-form-item(label="課程號碼")
              el-input(v-model="course.code")
            el-form-item(label="老師")
              el-input(v-model="course.teacher")
            el-form-item(label="時段")
              el-input(v-model="course.schedule", type="textarea", rows="5")
            el-form-item(label="地點")
              el-input(v-model="course.place")
            hr
            el-form-item(label="星球名稱")
              el-input(v-model="course.planetName")
            el-form-item(label="星球圖片")
              img(:src="course.planetSrc" width="100px")
              el-input(v-model="course.planetSrc")
               default_pic_selector(@select_pic="(obj)=>{course.planetSrc=obj.url}", slot="append")
            el-form-item(label="提醒")
             VueEditor.ve(:id ="'notice'", v-model="course.notice",
                    :useCustomImageHandler="true",
                    @imageAdded="handleImageAdded" ,
                    height="150px" )
            el-form-item(label="介紹")
             VueEditor.ve(:id ="'content'", v-model="course.content",
                    :useCustomImageHandler="true",
                    @imageAdded="handleImageAdded" ,
                    height="250px" )


        div(v-else) 選擇課程以編輯
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
      catas:[
        {
          id: 0,
          img: "/static/img/course_cata_1.svg",
          code: "DS5100",
          title: "核心課程",
          description: "建立學生觀察與解決問題的核心能力,讓學生具備合作發想與創新再造之能力｡課程包含:設計思考､使用者心理､說故事能力培養､腦力激盪､團隊合作技巧…等課程。"
        },
        {
          id: 1,
          img: "/static/img/course_cata_2.svg",
          code: "DS5200",
          title: "工作坊課程",
          description: "增強學生實作的能力與五感的敏銳度,協助學生強化創新構想的形成與執行,課程包含: 3D列印實務､簡報技巧､大數據分析､手繪訓練､色彩學､APP撰寫､縫紉技巧…等課程。",
        },
        {
          id: 2,
          img: "/static/img/course_cata_3.svg",
          code: "DS5300",
          title: "專題課程",
          description: "針對生活中各類實際議題,探討可行且創新的解決方案,課程涉及層面涵蓋:能源､人口､交通､居住､農業､環保､年長者關懷､醫療體系…等。",
        },
        {
          id: 3,
          img: "/static/img/course_cata_4.svg",
          code: "DS5400",
          title: "國際與企業專題",
          description: "聚焦業界或國際社會問題加以發想,以學生與校外人士共同發展並實踐創新成果為主軸,建立學生跨入社會實務的基礎與國際觀｡",
        }
      ]
    }
  },
  mounted(){
    
  },
  computed: {
    ...mapState(['courses','auth']),
    filtered_data(){
      let filtered = this.courses.filter(o=> (this.key=="" || o.name.indexOf(this.key)!=-1) )

      //如果分類檢視就過濾
      if (this.nowCataId!=-1){
        filtered = filtered.filter(obj=>obj.type== this.catas.find(c=>c.id==this.nowCataId).title )
      }
      let transformed = filtered.map(o=>{
        let nx = {...o}
        let cata = this.catas.find(mc=>mc.title==o.type)
        // nx.cataname = (cata && cata.type) || "-" 
        return nx
      })
      //如果是全部咧表就可以排序
      if (this.nowCataId==-1){
        transformed.sort((a,b)=>a.order_id>b.order_id?1:-1)
          .forEach((course,cid)=>{
            course.order_id=cid
          })
        this.saveAllCourse(transformed,false)

      }
      
      return transformed
    }
  },
  methods: {
    handleRowClick(row,event,column){
      this.creating=false
      this.editingId=row.id
      this.course=(this.courses || []).find(o=>o.id==this.editingId)
      this.course.current = this.course.current?true:false
      // console.log(row.id)
    },
    handleDelete(index,row){
// console.log(row)
      this.$confirm("你確定要刪除嗎？").then(()=>{
        axios.post(`/api/course/${row.id}`,{
          _method: 'DELETE',
          token: this.auth.token,
          dataType: 'JSON',
        }).then((res)=>{
  
          this.$message.success("刪除完成")
          this.$store.dispatch("loadCourses")
          // this.$router.push('/activity')
        })

      })
    },
    saveCourse(course){
      if (this.creating){
        this.creating=false
        let _this=this
        setTimeout(()=>{
          _this.$store.dispatch("loadCourses")
        },500)

        axios.post("/api/course",{
          ...course,
          token: this.auth.token
        }).then((res)=>{
          this.$store.dispatch("loadCourses")
          this.$message.success("新增成功!")
          let nm = res.data
          console.log("nm",nm)
          this.editingId=nm.id
          this.course=(this.courses || []).find(o=>o.id==this.editingId)
          // this.handleRowClick(nm,null,null)
        })
        
      }else{
        // console.log("儲存")
        axios.patch("/api/course/"+course.id,{
          ...course,
          token: this.auth.token
        }).then(()=>{
          this.$message.success("儲存成功!")

          this.$store.dispatch("loadCourses")
        })

      }
    },
    saveAllCourse(list,reload){
        axios.post("/api/course/updateAll",{
          courses: list,
          token: this.auth.token
        }).then((res)=>{
          if (reload!==false){
            this.$store.dispatch("loadCourses")
          }
        })
    },
    addNewCourse(){
      this.editingId=-1
      this.creating=true
      this.course={content: ""}
    },
    switchCata(cata){
      if (cata.id==this.nowCataId){
        this.nowCataId=-1
      }else{
        this.nowCataId=cata.id
      }
    },
    getOrderCount(cata){
      return this.courses.map(t=>t.type).filter(type=>type==cata.title).length
    },
    changeOrder(list,current,delta){
      let orderId = current.order_id
      let target = list.find(obj=>obj.order_id==orderId+delta)
      if (target){
        current.order_id=target.order_id
        target.order_id=orderId
      }
      this.saveAllCourse([current,target])
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
