<template>
  <div class="page-section">
    
    <div class="content">
        <div class="onCorners topLeft">
            
        </div>
        <div class="onCorners topRight">
            <img :style="{width:'200px'}" src="assets/index__sectionHeroText.svg"/>
        </div>
        <div class="onCorners bottomLeft"></div>
        <div class="onCorners bottomRight"></div>
        
    </div>
  </div>
</template>

<script>
export default {
    name: 'default',
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
        },
        getRandom: function() {
            
            return ('Original passed contents: ' + this.$props.contents + 'random number ' + (Math.random() * 100));
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
