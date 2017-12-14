<template lang="pug">
  .page.theme.white
    section.theme.white
      ul
        li(v-for="equip_record in equip_records")
          h4 \#{{equip_record.id}}
          h5 名字：{{equip_record.name}}
          h5 電話：{{equip_record.phone}}
          h5 帶出學院：{{equip_record.bringout?"是":"否"}}
          h5 借用時間：{{equip_record.start_datetime}}-{{equip_record.end_datetime}}
          h5 原因：{{equip_record.reason}}
          p 清單：
          ul
            li(v-for="equip_rent_item in equip_record.equip_rent_record")
              | {{equip_rent_item.equipment.name}}
              | x{{equip_rent_item.equipment.count}}
              | {{ get_equipment_confirm_type_translate(equip_rent_item.status).label }}

</template>

<script>
export default {
  data(){
    return {
      equip_records: []
    }
  },
  mounted(){
    axios.get("/api/user/equipment").then(res=>{
      this.equip_records=res.data
    })
  }
}
</script>

<style>

</style>
