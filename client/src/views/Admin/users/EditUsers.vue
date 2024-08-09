<script>
import Navbar from '@/components/Navbar.vue'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'EditUsers',
  components: { Navbar },
  setup(){
    const name = ref('')
    const email = ref('')
    const password = ref('')
    const password_confirmation = ref('')
    const selectRoles = ref([])
    const selectPermissions = ref([])
    const getRoles = ref([])
    const getPermissions = ref([])
    const user = ref([])
    const router = useRouter()
    let token = localStorage.getItem('token')

    const route = useRoute()
    //console.log(route.params.id)
    onMounted(async () => {
      const r = await axios.get(`http://localhost:8000/api/users/${route.params.id}`,{
        headers: {
          'Accept':'application/json',
          'Authorization':`Bearer ${token}`
        }
      })
      user.value = await r.data
      console.log(user.value.user.roles)
        name.value = user.value.user.name
        email.value = user.value.user.email
        password.value = ''
        password_confirmation.value = ''
        selectRoles.value = user.value.user.roles
        //selectPermissions.value = user.value.user.permissions
      console.log(name.value,email.value,password.value,password_confirmation.value,selectRoles.value)
    })
    // Collection des roles
    onMounted(async () => {
      const r = await axios.get('http://localhost:8000/api/roles',{
        headers: {
          'Accept':'application/json',
          'Authorization':`Bearer ${token}`
        }
      })
      getRoles.value = await r.data
     // console.log(getRoles.value.roles[0])

    })

    // Collection des permissions
   /* onMounted(async () => {
      const r = await axios.get('http://localhost:8000/api/permissions',{
        headers: {'Accept':'application/json'}
      })
      getPermissions.value = await r.data
     // console.log(getPermissions.value[0].name)

    })
*/
    //
    const onSubmit = async () => {
      try{
        const response = await axios.put(`http://localhost:8000/api/users/${route.params.id}`,{
          name:name.value,
          email: email.value,
          password: password.value,
          password_confirmation:password_confirmation.value,
          roles:selectRoles.value
          //permissions:selectPermissions.value
        },{
          headers: {
            'Content-Type':'application/json',
            'Authorization':`Bearer ${token}`
          },

        })

         user.value =await response.data
        console.log(user.value)
        if(user)
        {
          alert('L\'utilisateur a été bien modifié')
          await router.push('/admin')
        }else{
          alert('Modification échoué, Rééssayer')
        }

      }catch (e) {
        console.log('Erreur: Modification échoué')
      }

    }
    return{
      name,
      email,
      password,
      password_confirmation,
      selectRoles,
      //selectPermissions,
      onSubmit,
      getRoles,
      //getPermissions,
      user
    }
  }
}
</script>

<template>
  <Navbar />
    <div class="kotak_login">
      <p class="tulisan_login">Modifier un Utilisateur</p>

      <img src="https://freedesignfile.com/upload/2017/07/Hand-drawn-coffee-logos-design-vector-set-07.jpg" alt="coffee">

      <form @submit.prevent="onSubmit">
        <div class="form-group mb-3">
          <label>name</label>
          <input type="text" v-model="name" name="name" class="form_login" placeholder="Name..">
        </div>

        <div class="form-group mb-3">
          <label>Email</label>
          <input type="text" v-model="email" name="email" class="form_login" placeholder="Email..">
        </div>

        <div class="form-group mb-3">
          <label>Password</label>
          <input type="password" v-model="password"	name="password" class="form_login" placeholder="Password ..">
        </div>
        <div class="form-group mb-3">

          <label>Password Confirmation</label>
          <input type="password" v-model="password_confirmation"	name="password_confirmation" class="form_login" placeholder="Password ..">
        </div>
        <div class="form-group mb-3">
          <label>Role(s): </label>
          <select class="form-select" name="roles" v-model="selectRoles" id="roles" multiple>
            <option v-for="getRole in getRoles.roles" :key="getRole.id" :value="getRole.name" >{{getRole.name}}</option>
          </select>
        </div>
<!--
        <div class="form-group mb-3">
          <label>Permission(s): </label>
          <select class="form-select" name="permissions" v-model="selectPermissions" id="permissions" multiple>
            <option v-for="getPermission in getPermissions" :key="getPermissions.id" :value="getPermission.name">{{getPermission.name}}</option>
          </select>
        </div>
-->



        <input type="submit" class="tombol_login" value="Update">
      </form>

    </div>

</template>

<style scoped>
body {
  font-family: sans-serif;
  background: brown;
}

h1 {
  text-align: center;
  font-weight: 300;
}

.tulisan_login {
  text-align: center;

  text-transform: uppercase;
}

.kotak_login {
  width: 350px;
  background: #f2f2f2;
  /*tengah*/
  margin: 80px auto;
  padding: 30px 20px;
  box-shadow: 0 0 21px;
}

label {
  font-size: 11pt;
}

.form_login {
  box-sizing: border-box;
  width: 100%;
  padding: 10px;
  font-size: 11pt;
  margin-bottom: 20px;
}

.tombol_login {
  background: green;
  color: white;
  font-size: 11pt;
  width: 100%;
  border: none;
  border-radius: 3px;
  padding: 10px 20px;
  cursor:pointer;
}

.link {
  color: #232323;
  text-decoration: none;
  font-size: 10pt;
}

img {

  border-radius: 50%;
  width: 150px;
  margin: 0 auto;
  display: block;
}
input[type="submit"]:hover {
  background-color: #45a049;

}
select {
  -webkit-appearance:none;
  -moz-appearance:none;
  -ms-appearance:none;
  appearance:none;
  outline:0;
  box-shadow:none;
  border:0!important;
  background: #5c6664;
  background-image: none;
  flex: 1;
  padding: 0 .5em;
  color:#fff;
  cursor:pointer;
  font-size: 1em;
  font-family: 'Open Sans', sans-serif;
}
select::-ms-expand {
  display: none;
}
.select {
  position: relative;
  display: flex;
  width: 20em;
  height: 3em;
  line-height: 3;
  background: #5c6664;
  overflow: hidden;
  border-radius: .25em;
}
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 0 1em;
  background: #2b2e2e;
  cursor:pointer;
  pointer-events:none;
  transition:.25s all ease;
}
.select:hover::after {
  color: #23b499;
}
</style>