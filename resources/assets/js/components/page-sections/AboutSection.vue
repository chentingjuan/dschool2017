<template>
  <div class="aboutSection" :class="{blurred: !focused}">
    <!--
      REMINDER: CSS Classes on slots are removed in Vue 2.0
                Remember to properly use wrapper elements
     -->
    <div class="leftWrapper" :class="{themed: themeLeft, flipped: flipLeft, hideLeft: (layer > 0)}">
        <slot name="left"></slot>
    </div>
    <div class="rightWrapper" :class="{themed: themeRight, flipped: flipRight, expand: (layer > 0)}">
        <slot name="right"></slot>
    </div>
    <div>
        <slot name="abstract"></slot>
    </div>
  </div>
</template>

<script>
// Vuex
import { mapGetters } from 'vuex';

export default {
    name: 'AboutSection',
    data () {
        return {

        }
    },
    computed: {
        focused () {
            if (this.index === null) {
                // index is not supplied from the parent
                return true
            } else if (this.index === this.pageSectionIndex) {
                // index matches pageSectionIndex: is current section
                return true
            } else {
                // is not current section
                return false
            }
        },


        ...mapGetters({
            pageSectionIndex: 'pageSectionIndex'
        })
    },
    props: {
        contents: {
            required: false,
            type: Object
        },
        // Styling-related
        themeLeft: {
            type: Boolean,
            default: false,
            required: false
        },
        themeRight: {
            type: Boolean,
            default: false,
            required: false
        },
        flipLeft: {
            type: Boolean,
            default: false,
            required: false
        },
        flipRight: {
            type: Boolean,
            default: false,
            required: false
        },
        index: {                // Note: this prop will control the 
            type: Number,       //       fade-in/out animation by influencing
            default: null,      //       'focused' in computed.
            required: false
        },
        // Z-dimension
        layer: {
            type: Number,
            default: 0,
            required: false
        },
        totalLayers: {
            type: Number,
            default: 1,
            required: false
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
    },
    mounted () {
        this.$forceUpdate()
    }
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="sass">
@import '../../shared'

// Local Mixins
=fullHeight
    height: 100vh
=fullHeightPadded
    height: calc(100vh - 64px)
    padding-top: $pagePadding
    padding-bottom: $pagePadding

.aboutSection.blurred
    +hideNoPointer

.aboutSection
    display: flex
    +homePageTransitionLinear

    .leftWrapper
        +fullHeightPadded
        +flexCentre
        flex: 3
        max-width: 500px
        background: $gradient0
        position: relative
        +homePageTransitionFast

    .leftWrapper.hideLeft
        +hideNoPointer
        overflow: hidden
        // max-width: 0
        max-height: 0
    
    .rightWrapper
        +fullHeightPadded
        +flexCentre
        flex: 5
        background: $theme1
        position: relative
        +homePageTransitionFast

    .rightWrapper.expand
        background: $gradient0

    .themed
        background: $bgColour !important
    
    .leftWrapper.flipped
        background: $theme1
    .rightWrapper.flipped
        background: $gradient0

@media screen and (max-width: $mobileWidth)
    .aboutSection

        .leftWrapper
            // Left-side wrapper goes to top
        
        .rightWrapper
            // ...and right-side wrapper goes to bottom


</style>
