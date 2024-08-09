<script>
import { onMounted, ref } from 'vue'
import axios from 'axios'

export default {
  name: 'LoginToUserPage',
  setup(){
    const profile = ref([])
    let token = localStorage.getItem('token')
    onMounted( async () =>{
      const r = await axios.get('http://localhost:8000/api/profiles',{
        headers:{
          'Accept':'application/json',
          'Authorization':`Bearer ${token}`
        }
      })
      profile.value = await r.data
      console.log(profile.value.profiles)
      if (profile.value.profiles.length !== 0)
      {
        //localStorage.setItem('profile', JSON.stringify(profile.profiles))
        await router.push('/users')
      }else {
        await router.push('/create/profile')

      }
    })

  }

}
</script>

<template>

</template>

<style scoped>

</style>