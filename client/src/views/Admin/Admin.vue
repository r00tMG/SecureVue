<script>
export default {
  name: 'Admin',
  setup(){
    const role = localStorage.getItem('role')
    console.log(JSON.parse(role))
  }
}
</script>

<template>
Hello Admin
</template>

<style scoped>

</style>