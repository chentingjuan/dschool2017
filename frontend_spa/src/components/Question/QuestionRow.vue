<template lang="pug">
  .form-group(v-if="question")
    //label {{qaid+1}}. {{question.question}}
    input.form-control(v-model="question.question")
    select.form-control(v-model="question.type")
      option(value="short") 簡答
      option(value="long") 詳答
      option(value="select") 選擇
    .btn.btn-danger(@click="removeQuestion") 移除問題
</template>

<script>
export default {
  props: ['id'],
  data() {
    return {
      question: null
    }
  },
  mounted(){
    axios.get(`/api/question/${this.id}`).then((res)=>{
      Vue.set(this,"question",res.data)
    })
  },
  methods: {

    removeQuestion(){
      axios.post(`/api/question/${this.id}`,{
        _method: 'DELETE',
        _token: this.csrf_token
      }).then((res)=>{
        this.$emit("removeQuestion",this.id)
      })

    }
  }
}
</script>

<style>

</style>
