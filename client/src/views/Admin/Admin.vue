<script>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import Navbar from '@/components/Navbar.vue'
import UsersTable from '@/components/UsersTable.vue'
import EditUsers from '@/views/Admin/EditUsers.vue'
import RolesTable from '@/components/RolesTable.vue'

export default {
  name: 'Admin',
  components: { RolesTable, EditUsers, UsersTable, Navbar },
  setup(){
    const users = ref([])
    const role = localStorage.getItem('role')
    console.log(JSON.parse(role))

  }
}
</script>

<template>
  <body>
<Navbar />
  <div class="container about-school text-center">
    <div class="row my-5">
      <h1 class="wow bounceInUp animated lead ">
        SecureVue
      </h1>
      <div id="exTab3" class="container">
        <ul  class="nav nav-pills">
          <li class="color-blue col-lg-4">
            <a  href="#1b" data-toggle="tab"><i class="fa fa-book"></i>Users</a>
          </li>
          <li class="color-green col-lg-4">
            <a href="#2b" data-toggle="tab"><i class="fa fa-bus"></i>Rôles</a>
          </li>
          <li class="color-red col-lg-4">
            <a href="#3b" data-toggle="tab"><i class="fa fa-futbol-o"></i>Tap 3</a>
          </li>
        </ul>
        <div class="tab-content clearfix">
          <div class="tab-pane active" id="1b">
            <h3>Gestion des Utilisateurs</h3>
            <UsersTable />
          </div>
          <div class="tab-pane " id="2b">
            <h3><router-link to="/roles/create" class="btn btn-sm bg-primary">Create</router-link> Gestion des Rôles</h3>
            <RolesTable />
          </div>
          <div class="tab-pane" id="3b">
            <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  </body>
</template>

<style scoped>
#exTab3 .nav-pills > li > a {
  border-radius: 4px;
  font-size: 18px;
}
#exTab3 .nav-pills > li > a:hover{
  color:#fff;
}
#exTab3 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}
.nav-pills>li+li{
  margin-left: 0px !important;
  margin-bottom: 30px;
}
#exTab3 .nav-pills > li > a > i{
  display: block;
  font-size: 55px;
  margin-bottom:15px;
  -webkit-transition-duration: 0.7s;
  -moz-transition-duration: 0.7s;
  -o-transition-duration: 0.7s;
  transition-duration: 0.7s;
}
#exTab3 .nav-pills > li > a:hover i{
  -webkit-transform: scale(1.1,1.1) rotate(360deg);
  -moz-transform: scale(1.1,1.1) rotate(360deg);
  -o-transform: scale(1.1,1.1) rotate(360deg);
  transform: scale(1.1,1.1) rotate(360deg);
}
.nav-pills>li.color-blue>a, .nav-pills>li.color-blue>a:hover, .nav-pills>li.color-blue>a:focus{
  background-color: #337ab7 !important;
}
.nav-pills>li.color-green>a, .nav-pills>li.color-green>a:hover, .nav-pills>li.color-green>a:focus{
  background-color: #33b7a3 !important;
}
.color-green a, .color-red a, .color-blue a{
  color: #fff;
}
.nav-pills>li.color-red>a, .nav-pills>li.color-red>a:hover, .nav-pills>li.color-red>a:focus{
  background-color: #b73346 !important;
}
.nav>li>a:hover, .nav>li>a:focus{
  background-color: inherit;
}
#exTab3 .tab-content{
  background-color: inherit;
}
.tab-pane{
  padding: 5px 15px;
}
.tab-pane:nth-child(1){
  background-color: #337ab7 !important;
}
.tab-pane:nth-child(2){
  background-color: #33b7a3 !important;
}
.tab-pane:nth-child(3){
  background-color: #b73346 !important;
}
</style>