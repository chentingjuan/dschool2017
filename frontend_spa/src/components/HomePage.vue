 <template lang="pug">
.page.pageActivityList.manage
  section.sectionHero.blue.mt-5
    .container
      .row
        .col-sm-12
          h2 管理我的活動
      .row
        .col-sm-12(v-if="auth.user")
          h4.sub-title 你已經報名：
          br
          ul(v-if="registedActivityList && registedActivityList.length")
            li(v-for="activity in registedActivityList")
              ActivityInfoRow(:event_id="activity.activity_id", :key="activity.id")
          img(v-else src="/static/img/activity_timeout.svg")
        .col-sm-12(v-if="!auth.user")
          h4.sub-title 登入後可管理自己的活動
</template>

<script>
import {mapState} from 'vuex'
import ActivityInfoRow from './Activity/ActivityInfoRow'
export default {
    data(){
      return {
        registedActivityList: []
      }
    },
    created() {
        console.log('Component mounted.')
        axios.get("/api/user/activity", {
          params: {
            token: this.auth.token
          }
        }).then(res=>{
          
          this.registedActivityList=res.data
        })
    },
    computed:{
      ...mapState(['auth'])
    },
    components:{
      ActivityInfoRow
    }
}
</script>
<style lang="sass">
.pageActivityList
  padding-top: 50px
  h4.sub-title
    color: white
    opacity: 0.5  
    font-weight: 500
    font-size: 25px
  &.manage
    img
      width: 100%
      max-width: 400px

</style>