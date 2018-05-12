<template>
<transition name="menuLayer">
    <div v-show="menuEnabled" class="persistent transitionFast menuBgColour">
        <div class="float">
            <div class="onCorners topRight" @click="toggleMenu">
                <svg :style="{width:'40px',height:'60px'}" class="menuIcon">
                    <line x1="0" y1="10" x2="28" y2="38" class="iconLine" />
                    <line x1="0" y1="38" x2="28" y2="10" class="iconLine" />
                    
                </svg>
            </div>
            <div ref="menuShadow" class="menuShadow">
                <div class="item">{{getTranslation('MENU.INTRO')}}</div>
                <div class="item">{{getTranslation('MENU.CENTRE')}}</div>
                <div class="item">{{getTranslation('MENU.COURSES')}}</div>
                <div class="item">{{getTranslation('MENU.SERVICES')}}</div>
                <div class="item">{{getTranslation('MENU.NEWS')}}</div>
                <div class="item">{{getTranslation('MENU.QA')}}</div>
            </div>
            <div ref="menuDisplay" class="menuDisplay">
                <router-link to="/about">
                    <div class="item">_{{getTranslation('MENU.INTRO')}}</div>
                </router-link>
                    <div class="item">_{{getTranslation('MENU.CENTRE')}}</div>
                <a href="http://dschool.ntu.edu.tw/2017/courses/#/">
                    <div class="item">_{{getTranslation('MENU.COURSES')}}</div>
                </a>
                <div class="item">_{{getTranslation('MENU.SERVICES')}}</div>
                <div class="item">_{{getTranslation('MENU.NEWS')}}</div>
                <div class="item">_{{getTranslation('MENU.QA')}}</div>
            </div>
            <div class="onCorners bottomLeft langSelect">
                
                <span class="label"><span class="selector" @click="selectEN">EN</span> / <span class="selector" @click="selectZH">中文</span></span>
            </div>
        </div>
    </div>
</transition>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';

export default {
    name: 'HomeMenu',
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
    computed: {
        ...mapGetters({
            menuEnabled: 'menuEnabled'
        })
    },
    methods: {
        ...mapActions({
            toggleMenu: 'toggleMenu'
        }),
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
        closeMenu () {
            this.$emit('closeMenu', 'noAction');
        },
        /**
         * Animation-related Mouse-move Event Handler
         */
        handleMouseMove (eV) {
            let xRatio = (eV.clientX / window.innerWidth);
            let yRatio = (eV.clientY / window.innerHeight);
            requestAnimationFrame(() => {
                this.$refs.menuDisplay.style.transform = 'translate3d(' + xRatio * 20 + 'px,' + yRatio * 28 + 'px, 0)';
                this.$refs.menuShadow.style.transform = 'translate3d(' + xRatio * 10 + 'px,' + yRatio * 15 + 'px, 0)';
            });
        },
        /**
         * Pass language configuration to the parent component
         */
        selectEN () {
            this.$emit('selectLang', 'EN');
            this.$forceUpdate();
        },
        selectZH () {
            this.$emit('selectLang', 'ZH');
            this.$forceUpdate();
        }
    },
    mounted () {
        // TODO: add mobile gyroscope support
        //window.addEventListener('mousemove', this.handleMouseMove);
    },
    beforeDestroy () {
        // TODO: add mobile gyroscope support
        //window.removeEventListener('mousemove', this.handleMouseMove);
    },
    watch: {
        menuEnabled () {
            if (!this.menuEnabled) {
                window.removeEventListener('mousemove', this.handleMouseMove);
            } else {
                window.addEventListener('mousemove', this.handleMouseMove);
            }
        }
    }
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="sass">
@import '../shared'

.transitionFast
    +homePageTransitionFast
.menuBgColour
    background: $bgColour

.menuIcon
    
    .iconLine
        stroke: $gradient0
        stroke-width: 3px
.menuIcon:hover
    cursor: pointer
    .iconLine
        stroke: $theme1
        

.menuDisplay
    position: absolute
    left: 50vw
    display: flex
    flex-direction: column
    justify-content: space-between
    align-items: stretch
    height: calc(100vh - 128px)
    padding: $pagePadding
    max-width: 250px

    .item
        color: $gradient0
        font-size: 2em
        font-weight: 600
    .item:hover
        color: $theme1
        cursor: pointer

.menuShadow
    position: absolute
    left: calc(50vw - 80px)
    display: flex
    flex-direction: column
    justify-content: space-between
    align-items: stretch
    height: calc(100vh - 128px)
    padding: $pagePadding
    max-width: 250px
    pointer-events: none
    opacity: 0.2

    .item
        color: $gradient0
        font-size: 1.6em
        font-weight: 600

.langSelect
    +foreGroundColour
    +flexCentre
    font-size: 0.8em
    font-weight: 600

    .icon
        height: 48px
        padding-right: 10px
    .selector:hover
        cursor: pointer

/* Transitions */
.menuLayer-enter-active, .menuLayer-leave-active 
  +homePageTransitionFast
  

.menuLayer-enter 
  opacity: 0

.menuLayer-leave-to 
  opacity: 0
  pointer-events: none

</style>
