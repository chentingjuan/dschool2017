<template lang="pug">
  .page.pageEquipmentList
    section.sectionHero.theme.white
      .container
        .row
          .col-sm-12
            h1 學院設備租借
            br
        .row
          .col-sm-3
            h3.service_progress(@click="stage=1", :class="{active: stage>=1}") 填寫申請
          .col-sm-3
            h3.service_progress(@click="stage=2", :class="{active: stage>=2}") 選擇設備
          .col-sm-3
            h3.service_progress(@click="stage=3", :class="{active: stage>=3}") 確認內容
          .col-sm-3 
            h3.service_progress(:class="{active: stage>=4}") 租借完成
        .row
          .col-sm-12(v-if="stage==1")
            h3 申請人資料
            br
            .row
              .col-sm-3
                label 申請人姓名
              .col-sm-9
                input.form-control(v-model="apply.name", type="name")
            
            .row
              .col-sm-3
                label 申請人電話
              .col-sm-9
                input.form-control(v-model="apply.phone", type="name")
            
            .row
              .col-sm-3
                label 借用開始時間
              .col-sm-9
                //- input.form-control(v-model="apply.start_datetime", type="datetime")
                datePicker(v-model="apply.start_datetime", name="apply_start_time", :config="{format: 'YYYY-MM-DD HH:mm',useCurrent: true,showClear: true,stepping: 60,sideBySide: true}")
            .row
              .col-sm-3
                label 借用結束時間
              .col-sm-9
                datePicker(v-model="apply.end_datetime", name="apply_end_time", :config="{format: 'YYYY-MM-DD HH:mm',useCurrent: true,showClear: true,stepping: 60,sideBySide: true}")
            
            .row
              .col-sm-3
                label 申請原因
              .col-sm-9
                textarea.form-control(v-model="apply.reason", type="name")

            .row
              .col-sm-3
                label 是否攜出學院
              .col-sm-9
                input.form-control(type="checkbox" v-model="apply.bringout")
            .row
              .col-sm-12
                .btn.orange(@click="stage=2") 下一步驟
            
        .row(v-if="stage==2")
          .list-group.col-sm-2.list-catas
            input.form-control(v-model="keyword",
              placeholder="輸入關鍵字...")
            .btn.orange(@click="stage=3") 確認租借
            br
            br
            .list-group-item(
              v-for="cata in catas",
              @click="now_cata=cata",
              :class="{active: cata==now_cata}") {{cata}}
            .list-group-item(
              @click="now_cata=''",
              :class="{active: now_cata==''}") 全部類別
          .col-sm-10
            ul.row.list-group.list-equip
              li.col-sm-3.list-group-item(
                v-for="equip in filtered_equipments",
                :class="{ active: equip.user_count>0 }",
                :key="equip.name+equip.id")
                .img
                h5 {{ equip.cata }}
                h4 {{ equip.name }} x{{ equip.count }}
                p {{ equip.model }}
                | {{equip.accessories}}
                br
                .btn-group
                  .btn.grey.outline(@click="user_count_delta(equip,-1)") -
                  .btn.grey.outline {{ equip.user_count }}
                  .btn.grey.outline(@click="user_count_delta(equip,1)") + 
          .list-group.fixed_cart
            ul.cart-list
              li.list-group-item(v-for="equip_item in equip_list")
                span {{ equip_item.name }}
                span  x {{ equip_item.user_count }}
                .btn-remove(@click="equip_item.user_count=0") x
            li.list-group-item
              //- p {{ total }}<br>保證金{{ensure_money}}元
            .btn.orange(@click="stage=3") 確認租借

        .row(v-if="stage==3")
          .col-sm-12
            //- pre(v-html="equip_rent")
            panel.panel-default
              .panel-body.container-fluid
                .row
                  .col-sm-3
                    label 借用人名字
                  .col-sm-9
                    label {{apply.name}}
                .row
                  .col-sm-3
                    label 借用人電話
                  .col-sm-9
                    label {{apply.phone}}

                .row
                  .col-sm-3
                    label 借用原因
                  .col-sm-9
                    label {{apply.reason}}

                .row
                  .col-sm-3
                    label 是否攜出學院
                  .col-sm-9
                    label {{apply.bringout?"是":"否"}}

                .row
                  .col-sm-3
                    label 借用開始時間
                  .col-sm-9
                    label {{apply.start_datetime}}

                .row
                  .col-sm-3
                    label 借用結束時間
                  .col-sm-9
                    label {{apply.end_datetime}}

                .row(v-if="apply.bringout")
                  .col-sm-3
                    label 參考押金(攜出學院)
                  .col-sm-9
                    label {{ensure_money}}元
                  
                .row
                  .col-sm-12
                    h3 借用設備清單
                    ol
                      li(v-for="equip in equip_list")
                        h4 {{equip.name}}
                          span x {{equip.count}}
                
                .row
                  .col-sm-12
                    hr
                    br
                    
                    h3 
                      br
                      | 借用設備注意事項
                      br

                    h4(v-if="apply.bringout") 攜出使用須繳納的押金將依借用情形調整，實際金額請見審核通知信，並於領取設備時全額繳交。

                    p 請於預約時間領取與歸還設備，累計2次未準時領取或歸還者，將列入黑名單（如：1次未準時領取+1次未準時歸還=列入黑名單），此後不予借用設備。
                      | <br>單次借用期限為10天(借用日為第1天)，同類設備限借1台，期滿後，借用者應主動歸還，逾期歸還則以單日租借費用100元計算，直至實際歸還日為止。
                      | <br>設備器材攜出學院空間須繳交押金，待器材歸還經確認無損毀，則歸還押金。
                      | <br>借用者（單位）於借用期間須保管借用設備並不得轉借他人，並負設備損壞賠償責任。
                      | <br>不得安裝非法軟體與存入非經授權的機密資料，歸還前借用者需自行將個人重要資料備份並從設備中將個人資料刪除。
                      | <br>本設備僅限於公務使用，禁止用於私人用途。外借可攜式設備(如筆記型電腦)，於使用時切勿拆卸相關零組件(如：硬碟機、光碟機、記憶體等...)，如有更動到原配置之硬體規格者，將視情況要求賠償。不可將可攜式設備(如筆記型電腦)或可攜式儲存媒體置於視線以外之處並隨身攜帶以避免遺失遭竊。

                    hr

                .row
                
                  .col-sm-12
                    .btn.orange(@click="confirm_order") 確認借用資訊


        .row(v-if="stage==4")
          .col-sm-12
            h3 完成借用申請
            h4 借用單號 \#{{equip_rent.id}}
            //pre(v-html="equip_rent")
            router-link.btn.orange(to="/my/equipment") 前往我的申請清單


</template>

<script>
import {mapState} from 'vuex'
import axios from 'Axios'

import datePicker from 'vue-bootstrap-datetimepicker'
export default {
  data(){
    return {
      equipments: [],
      now_cata: "",
      keyword: "",
      stage: 1,
      apply:{
        name: "",
        phone: "",
        reason: "",
        bringout: false,
        start_datetime: "",
        end_datatime: ""
      },
      equip_rent: null,
    }
  },
  mounted(){
    axios.get("/api/equipment").then(res=>{
      let equipments = res.data
      equipments.forEach(obj=>{
        obj.user_count=0
      })
      this.equipments = equipments
    })
    if (this.user){
      this.apply.name=this.user.name
      this.apply.phone=this.user.phone
    }
  },
  computed:{
    ...mapState(['user']),
    filtered_equipments(){
      return this.equipments
        .filter(obj=>{
          return obj.show
        })
        .filter(obj=>{
          return obj.auth!="職員限定"
        })
        .filter(obj=>{
          return this.now_cata=="" || obj.cata==this.now_cata
        })
        .filter(obj=>{
          return this.keyword=="" || JSON.stringify(obj).toLowerCase().indexOf(this.keyword.toLowerCase())!=-1
        })
        .filter(obj=>obj)
      
    },
    equip_list(){
      return this.equipments.filter(obj=>obj.user_count>0)
    },
    total(){
      return `總共借了 ${this.equip_list.length} 項物品`
    },
    catas(){
      return this.equipments.map(o=>o.cata).filter((d,i,arr)=>arr.indexOf(d)==i)
    },
    ensure_money(){
      return this.equip_list.reduce((total,now)=>{
        return total+parseInt( now.deposit || 0)
      },0)
    }
  },
  methods:{
    user_count_delta(equip,delta){
      if ( equip.user_count<=0 && delta<0){

      }else if (equip.user_count + delta <= equip.count){
        equip.user_count += delta
      }
    },
    sendRent(){
      let message = ""
      message+="設備清單列表\n"
      message+="--------\n"
      this.equip_list.forEach(o=>{
        message+=o.name + " x"+o.user_count
        if (o.deposit){
          message+=" (保證金"+o.deposit+"元)"
        }
        message+="\n"
      })
      message+="----------\n"
      message+="保證金: "+ this.ensure_money
     
      // alert(message)
    },
    confirm_order(){
       axios.post("/api/equipment/rent",{
        name: this.apply.name,
        phone: this.apply.phone,
        reason: this.apply.reason,
        bringout: this.apply.bringout,
        start_datetime: this.apply.start_datetime,
        end_datetime: this.apply.end_datetime,
        equips: this.equip_list
      }).then(res=>{
        this.equip_rent=res.data
        this.stage=4
      })
    }
  },
  components:{
    datePicker
  }

}
</script>

<style>
p{
  margin-top: 10px !important;
  margin-bottom: 10px !important;
}
</style>
