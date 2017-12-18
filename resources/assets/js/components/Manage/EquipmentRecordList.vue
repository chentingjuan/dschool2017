<template lang="pug">
  .page.theme.white
    .container
      .row
        .col-sm-12
          h1 租借設備審核
          hr
      //.row
        .col-sm-12
          vue_lazy_table(:table_data="require_datas",
                          :rows="rows")
      .row
        .col-sm-12
          ul.list-group
            li.list-group-item(v-for="(equip_record,eid) in equip_records").row
              .col-sm-1
                h3 \#{{equip_record.id}}
              .col-sm-3
                h5 名字： {{equip_record.name}}
                h5 電話： {{equip_record.phone}}
                h5 帶出學院： {{equip_record.bringout?"是":"否"}}
                h5 借用開始時間： {{equip_record.start_datetime}}
                h5 借用結束時間： {{equip_record.end_datetime}}
                h5 參考保證金： {{equip_record.ensure_money}}
                h5 申請時間： {{equip_record.created_at}}
                h5 原因： {{equip_record.reason}}
              .col-sm-6
                ul.list-group
                  li.list-group-item(v-for="equip_rent_item in equip_record.equip_rent_record")
                    | {{equip_rent_item.equipment.name}}
                    | x{{equip_rent_item.equipment.count}}
                    |  ({{ get_equipment_confirm_type_translate(equip_rent_item.status).label }})
                    .btn-group.pull-right
                      .btn.grey.outline(
                        :class="{active: equip_rent_item.status=='yes'}",
                                @click="equip_rent_item.status='yes'") 核准
                      .btn.grey.outline(
                        :class="{active: equip_rent_item.status=='no'}",
                                @click="equip_rent_item.status='no'") 不核准
              .col-sm-2
                h4 狀態：{{ equip_record.confirmed?'已審核':'未審核' }}
                .form-group(v-if="equip_record.bringout")
                  label 需繳納保證金：
                  input.form-control(:placeholder="equip_record.ensure_money", v-model="equip_record.custom_deposit")
                .form-group
                  label 領取日期：
                  datePicker(:placeholder="equip_record.start_datetime", v-model="equip_record.custom_start_datetime", name="event_time", :config="{format: 'YYYY-MM-DD HH:mm',useCurrent: true,showClear: true,stepping: 60}")
                .btn.orange(v-if="!equip_record.confirmed",
                            @click="confirmRecord(equip_record,eid)") 審核確認
                .btn.grey.outline(v-if="equip_record.confirmed",
                            @click="cancelRecord(equip_record,eid)") 取消

</template>

<script>
import vue_lazy_table from '../Data/vue_lazy_table'
import datePicker from 'vue-bootstrap-datetimepicker'

export default {
  data(){
    return {
      equip_records: [],
      rows: [
        "id -> #",
        "name -> 借用人",
        "phone -> 電話",
        "reason -> 借用理由",
        "bringout -> 帶出學院",
        "cancel -> __hide",
        "confirmed -> 確認",
        "paid -> 付款",
        "return -> 歸還",
        "ensure_money -> 參考保證金",
        "start_datetime -> 借用開始",
        "end_datetime -> 借用結束",
        "created_at -> 申請時間",
        "updated_at -> __hide",
        "content -> 借用細節",
        "content -> 借用細節",
        "content -> 借用細節",
        
        
      ]
    }
  },
  mounted(){
    axios.get("/api/user/equipment").then(res=>{
      res.data.forEach(o=>{
        o.ensure_money = o.equip_rent_record.reduce((total,a)=> 
           total+ a.equipment.deposit || 0,0)
      })
        //  ensure_money: r.equip_rent_record.reduce((total,a)=> 
          //  total+ a.equipment.deposit || 0,""),
      this.equip_records=res.data.reverse()
    })
  },
  computed:{
    require_datas(){

      let result = this.equip_records
        .map(r=>({
         ...r , 
         bringout: r.bringout?"是":"否",
         confirmed: r.confirmed?"是":"否",
         paid: r.paid?"是":"否",
         return: r.return?"是":"否",
         content: r.equip_rent_record.reduce((total,a)=> 
           total+ a.equipment.name+" x"+ a.equipment.count+" (" 
           + this.get_equipment_confirm_type_translate(a.status).label
           + this.get_equipment_confirm_type_translate(a.status).symbol + ")\n"
         ,"")
      }))
      return result
    }
  },
  components: {
    vue_lazy_table,
    datePicker
  },
  methods: {

    cancelRecord(equip_record,eid){
      equip_record.equip_rent_record.forEach(r=>r.status="unconfirmed");
      axios.post("/api/equipment/confirm",{...equip_record,cancel_confirm:true}).then(res=>{
        res.data.data.ensure_money = res.data.data.equip_rent_record
            .reduce((total,a)=>  total+ a.equipment.deposit || 0,0)
        
        Vue.set(this.equip_records,eid,res.data.data)
        alert("已取消"+res.data.status)
      })
    },
    confirmRecord(equip_record,eid){
      if (confirm("確認審核並寄信通知使用者嗎？")){
        axios.post("/api/equipment/confirm",{...equip_record}).then(res=>{
          res.data.data.ensure_money = res.data.data.equip_rent_record
              .reduce((total,a)=>  total+ a.equipment.deposit || 0,0)
          Vue.set(this.equip_records,eid,res.data.data)
          alert("已確認"+res.data.status)
        })
      }
    }


  }
}
</script>

<style>

</style>
