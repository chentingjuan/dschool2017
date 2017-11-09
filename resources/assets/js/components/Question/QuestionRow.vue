<template lang="pug">

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
