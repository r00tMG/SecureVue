<script>
import Navbar from '@/components/Navbar.vue'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'EditProfile',
  components: { Navbar },
  setup(){
    const address = ref('')
    const hobbies = ref('')
    const job = ref('')
    const skill = ref('')
    const user_id = ref('')
    const profile = ref({})
    const router = useRouter()
    let token = localStorage.getItem('token')
    let getUser = JSON.parse(localStorage.getItem('user'))
    console.log(getUser)

    const route = useRoute()
    //console.log(route.params.id)
    onMounted(async () => {
      const r = await axios.get(`http://localhost:8000/api/profiles/${route.params.id}`,{
        headers: {
          'Accept':'application/json',
          'Authorization':`Bearer ${token}`
        }
      })
      profile.value = await r.data
      console.log(profile.value.profiles)
      address.value = profile.value.profiles[0].address
      hobbies.value = profile.value.profiles[0].hobbies
      job.value = profile.value.profiles[0].job
      skill.value = profile.value.profiles[0].skill
      user_id.value = getUser.id

    })
    // Collection des roles
    /*onMounted(async () => {
      const r = await axios.get('http://localhost:8000/api/roles',{
        headers: {
          'Accept':'application/json',
          'Authorization':`Bearer ${token}`
        }
      })
      getRoles.value = await r.data
      // console.log(getRoles.value.roles[0])

    })*/

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
        const response = await axios.put(`http://localhost:8000/api/profiles/${route.params.id}`,{
          address:address.value,
          hobbies: hobbies.value,
          job: job.value,
          skill:skill.value,
          user_id:getUser.id

        },{
          headers: {
            'Content-Type':'application/json',
            'Authorization':`Bearer ${token}`
          },

        })

        profile.value =await response.data
        console.log(profile.value)
        if(profile)
        {
          alert('Votre profile a été bien modifié')
          await router.push('/users')
        }else{
          alert('Modification échoué, Rééssayer')
        }

      }catch (e) {
        console.log('Erreur: Modification échoué')
      }

    }
    return{
      address,
      hobbies,
      job,
      skill,
      user_id,
      onSubmit
    }
  }
}
</script>

<template>
  <Navbar />
  <div class="kotak_login">
    <p class="tulisan_login">Modifier votre profile Utilisateur</p>

    <img src="https://freedesignfile.com/upload/2017/07/Hand-drawn-coffee-logos-design-vector-set-07.jpg" alt="coffee">

    <form @submit.prevent="onSubmit">
      <div hidden="true" class="form-group mb-3">
        <label>User</label>
        <input type="text" v-model="user_id" name="user_id" class="form_login" placeholder="User..">
      </div>
      <div class="form-group mb-3">
        <label>Address</label>
        <input type="text" v-model="address" name="address" class="form_login" placeholder="Address..">
      </div>

      <div class="form-group mb-3">
        <label>Hobbies</label>
        <input type="text" v-model="hobbies" name="hobbies" class="form_login" placeholder="Hobbies..">
      </div>

      <div class="form-group mb-3">
        <label>Job</label>
        <input type="text" v-model="job"	name="job" class="form_login" placeholder="Job ..">
      </div>
      <div class="form-group mb-3">
        <div class="form-group mb-3">
          <label>Skill</label>
          <input type="text" v-model="skill" name="skill" class="form_login" placeholder="Skill..">
        </div>
      </div>

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