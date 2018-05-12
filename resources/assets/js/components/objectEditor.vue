<template lang="pug">
div.objectEditor
  el-form(:model="value", label-width="100px")
    el-form-item(v-for="(data,key) in value",
                  :label = "key",
                 v-if="!is_hidden(key)")
      el-input(v-if="key =='cover'" ,v-model="value[key]")
        img(:src="value[key]", style="width: 100%;max-width: 100px")
        default_pic_selector(@select_pic="(obj)=>value[key]=obj.url")
      div(v-else-if="key =='content'").row
        VueEditor.ve(:id ="'content'", v-model="value[key]",
                  :useCustomImageHandler="true",
                  @imageAdded="handleImageAdded"  )
      el-input(v-model="value[key]" v-else)
  
</template>

<script>
import default_pic_selector from './default_pic_selector.vue'
import { VueEditor } from 'vue2-editor'
export default {
  props: [
    'value','hidden'
  ],

  components:{
    VueEditor , 
    default_pic_selector, 
  },
  methods: {
    is_hidden(key){
      return (this.hidden || []).indexOf(key)!=-1
    }
  }
}
</script>

<style>

</style>
