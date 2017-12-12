<template lang="pug">
  .page.pageEquipmentList
    section.sectionHero.theme.white
      .container
        .row
          .col-sm-12
            h1 學院設備清單
            br
        .row
          .list-group.col-sm-2.list-catas
            input.form-control(v-model="keyword",
              placeholder="輸入關鍵字...")
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
              p {{ total }}<br>保證金{{ensure_money}}元
            .btn.orange(@click="sendRent") 確認租借

</template>

<script>
import {mapState} from 'vuex'
import axios from 'Axios'
export default {
  data(){
    return {
      equipments: [],
      now_cata: "",
      keyword: ""
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
      alert(message)
    }
  }
}
</script>

<style>
p{
  margin-top: 10px !important;
  margin-bottom: 10px !important;
}
</style>
