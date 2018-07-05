import ManageLayout from "../components/manage/Layout.vue"

import ManageActivityRegister from "../components/Manage/ActivityRegister.vue"
import ManageActivitEdit from "../components/Manage/ActivityEdit.vue"
import ManageActivity from "../components/Manage/Activity.vue";
import ManageUser from "../components/Manage/User.vue"
import ManagePostList from "../components/Manage/PostList.vue"
import ManagePostEdit from "../components/Manage/Post.vue"
import ManageMemberEdit from "../components/Manage/Member.vue"
import ManageQuestionEdit from "../components/Manage/Question.vue"
import ManageEquipList from "../components/manage/EquipmentRecordList.vue"

let routes = {
  path: "/manage",
  component: ManageLayout,
  children: [
    {
      path: "",
      redirect: "post",
      meta: {
        title: "管理"
      }
    },
    {
      path: "post",
      component: ManagePostList,
      meta: {
        title: "新聞列表",
        mainNav: true
      }
    },
    {
      path: "post/new",
      component: ManagePostEdit,
      props: true,
      meta: {
        title: "新增文章"
      }
    },
    {
      path: "post/:post_id",
      component: ManagePostEdit,
      props: true,
      meta: {
        title: "文章編輯"
      }
    },
    {
      path: "activity",
      component: ManageActivity,
      meta: {
        title: "管理活動",
        mainNav: true
      }
    },
    {
      path: "activity/new",
      component: ManageActivitEdit,
      meta: {
        title: "新增活動"
      }
    },
    {
      path: "activity/:event_id/list",
      component: ManageActivityRegister,
      props: true,
      meta: {
        title: "活動報名清單"
      }
    },
    {
      path: "activity/:event_id",
      component: ManageActivitEdit,
      props: true,
      meta: {
        title: "活動管理"
      }
    },
    {
      path: "member",
      component: ManageMemberEdit,
      props: true,
      meta: {
        title: "團隊成員",
        mainNav: true
      }
    },
    {
      path: "member/:id",
      component: ManageMemberEdit,
      props: true,
      meta: {
        title: "會員資料"
      }
    },
    {
      path: "question",
      component: ManageQuestionEdit,
      props: true,
      meta: {
        title: "問答管理",
        mainNav: true
      }
    },
    {
      path: "question/:id",
      component: ManageQuestionEdit,
      props: true,
      meta: {
        title: "問答"
      }
    },
    {
      path: "user",
      component: ManageUser,
      props: true,
      meta: {
        title: "會員管理",
        mainNav: true
      }
    },
    {
      path: "equipment/list",
      component: ManageEquipList,
      meta: {
        title: "設備管理",
        mainNav: true
      }
    }
  ]
};

export default routes