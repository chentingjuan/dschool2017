 <template lang="pug">
.page.pageActivityList
  section.sectionHero.blue
    .container
      .row
        .col-sm-12
          h2 管理我的活動
          br
      .row
        .col-sm-12(v-if="user")
          h4 你已經報名：
          ul(v-if="registedActivityList")
            li(v-for="activity in registedActivityList")
              ActivityInfoRow(:event_id="activity.activity_id", :key="activity.id")
        .col-sm-12(v-if="!user")
          h4 登入後可以管理自己的活動
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
    mounted() {
        console.log('Component mounted.')
        axios.get("/api/user/activity").then(res=>{
          this.registedActivityList=res.data
        })
    },
    computed:{
      ...mapState(['user'])
    },
    components:{
      ActivityInfoRow
    }
}
</script>
