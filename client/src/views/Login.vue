<script>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default {
  name: 'Login',
  setup(){
    const email = ref('')
    const password = ref('')
    const router = useRouter()
    const onLogin = async () => {
      try{
        const response = await axios.post('http://localhost:8000/api/login', {
            email: email.value,
            password: password.value
        },{
          headers: { 'Content-Type':'application/json' },

        })

        const data = response.data
        console.log(data.user.role)
        //await router.push('/register')
       if(data.token && (data.user.role[0].name === "admin" || data.user.role[0].name === "super-admin"))
        {
          localStorage.setItem('token',data.token)
          localStorage.setItem('role',JSON.stringify(data.user.role))
          localStorage.setItem('user',JSON.stringify(data.user))
          await router.push('/admin')
        }else if(data.token && data.user.role[0].name === "user"){
          localStorage.setItem('token',data.token)
          localStorage.setItem('role',JSON.stringify(data.user.role))
          localStorage.setItem('user',JSON.stringify(data.user))
          await router.push('/users')
        }else {
          alert('Authentification échouée')
        }
      }catch (e) {
        console.log('Erreur: Connexion échoué')
      }

    }
    return{
      email,
      password,
      onLogin
    }
  }
}
</script>

<template>

    <div class="kotak_login">
      <p class="tulisan_login">Login</p>

      <img src="https://freedesignfile.com/upload/2017/07/Hand-drawn-coffee-logos-design-vector-set-07.jpg" alt="coffee">

        <form @submit.prevent="onLogin">
          <label>Username</label>
          <input type="text" v-model="email" name="email" class="form_login" placeholder="Username..">

          <label>Password</label>
          <input type="password" v-model="password"	name="password" class="form_login" placeholder="Password ..">

          <input type="submit" class="tombol_login" value="LOGIN">
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

</style>