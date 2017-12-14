<template lang="pug">
  .page.theme.white
    section.theme.white
      .container
        .row
          .col-sm-12
            vue_lazy_table(:table_data="require_datas",
                            :rows="rows")
        //.row
          .col-sm-12
            ul
              li(v-for="equip_record in equip_records")
                h4 \#{{equip_record.id}}
                h5 名字：{{equip_record.name}}
                h5 電話：{{equip_record.phone}}
                h5 帶出學院：{{equip_record.bringout?"是":"否"}}
                h5 借用時間：{{equip_record.start_datetime}}-{{equip_record.end_datetime}}
                h5 原因：{{equip_record.reason}}
                h5 申請時間：{{equip_record.created_at}}
                p 清單：
                ul
                  li(v-for="equip_rent_item in equip_record.equip_rent_record")
                    | {{equip_rent_item.equipment.name}}
                    | x{{equip_rent_item.equipment.count}}
                    | {{ get_equipment_confirm_type_translate(equip_rent_item.status).label }}

</template>

<script>
import vue_lazy_table from '../Data/vue_lazy_table'

export default {
  data(){
    return {
      equip_records: [],
      rows: [
        "id -> #",
        "name -> 姓名",
        "phone -> 電話",
        "reason -> 理由",
        "bringout -> 帶出學院",
        "cancel -> __hide",
        "confirmed -> 審核",
        "paid -> 付款",
        "return -> 歸還",
        "start_datetime -> 開始時間",
        "end_datetime -> 結束時間",
        "created_at -> 申請時間",
        "updated_at -> __hide",
        "content -> 借用細節",
        
        
        "user_id -> __hide",
        "equip_rent_record -> __hide",
        
      ]
    }
  },
  mounted(){
    axios.get("/api/user/equipment").then(res=>{
      this.equip_records=res.data
    })
  },
  computed:{
    require_datas(){

      let result = this.equip_records
        .map(r=>({
         ...r , 
         bringout: r.bringout?"是":"否",
         confirmed: r.confirmed?"已審核":"尚未",
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
    vue_lazy_table
  }
}
</script>

<style>

</style>
