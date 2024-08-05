<script>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

export default {
  name: 'UsersTable',
  setup(){
    const users = ref([])
    const route = useRoute()
    onMounted(async () => {
      const token = localStorage.getItem('token')
      const r = await axios.get('http://localhost:8000/api/users',{
        headers:{
          'Content-Type':'application/json',
          'Authorization':`Bearer ${token}`
        }
      })
      users.value = await r.data
      //console.log(users.value)
    })
    const onDelete = async (id) => {
      console.log(id)
      if (id !== null)
      {
        if(confirm("Êtes-vous sûre?"))
        {
          const token = localStorage.getItem('token')
          await axios.delete(`http://localhost:8000/api/users/${id}`,{
            headers:{'Authorization':`Bearer ${token}`}
          })
        }
      }else{
        alert("Cette utilisateur n'est pas trouvé")
      }

    }
    return{
      users,
      onDelete
    }
  }
}
</script>

<template>
  <div class="table-responsive">
    <table class="table ">
      <thead class="table-dark">
      <tr>
        <th class="text-center">Name</th>
        <th class="text-center">Email</th>
        <th class="text-center" colspan="2">Rôle</th>
        <th class="text-center" colspan="2">Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-if="users" v-for="user in users.users" :key="user.id">
        <td v-text="user.name"></td>
        <td v-text="user.email"></td>
        <td ><span v-if="user.roles" v-for="role in user.roles" class="badge bg-primary">{{role.name}}</span></td>
        <td>

        </td>
        <td>
          <button type="submit" class="btn btn-sm btn-danger" @click.prevent="onDelete(user.id)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
          </svg></button>
          <router-link :to="`/users/${user.id}/edit`" class="btn btn-sm btn-success" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
          </svg></router-link>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>

</style>