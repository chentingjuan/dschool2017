<template>
  <div class="page-section">
  </div>
</template>

<script>
export default {
    name: 'HomeSection5',
    data () {
        return {

        }
    },
    props: {
        contents: {
            required: false,
            type: Object
        }
    },
    methods: {
        getTranslation (name) {
            if (name.indexOf('.') != -1) {
                // Process object tree
                let ns = name.split('.');
                let ref = LANG[ns[0]];
                for (let i = 1; i < ns.length; ++i ) {
                    // Tree into the object
                    ref = ref[ns[i]];
                }
                return ref;
            }
            return LANG[name];
        }
    }
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="sass">
@import '../../shared'
.page-section 
    background: $bgColour
    display: flex
    align-items: center
    justify-content: center
</style>
