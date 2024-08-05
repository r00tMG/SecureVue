import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import Register from '@/views/Register.vue'
import Admin from '@/views/Admin/Admin.vue'
import User from '@/views/User/User.vue'
import EditUsers from '@/views/Admin/EditUsers.vue'
import RolesCreate from '@/views/Admin/RolesCreate.vue'
import EditRoles from '@/views/Admin/EditRoles.vue'
import EditProfile from '@/views/User/EditProfile.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: Login
    },
    {
      path:'/register',
      name: 'register',
      component: Register
    },
    {
      path: '/admin',
      name: 'admin',
      component: Admin,
      meta: {requiresAuth: true}
    },
    {
      path: '/users',
      name: 'user',
      component: User,
      meta: {requiresAuth: true}
    },
    {
      path: '/users/:id/edit',
      name: 'edit',
      component: EditUsers,
      meta: {requiresAuth: true}
    },
    {
      path: '/roles/create',
      name: 'roles/create',
      component: RolesCreate,
      meta: {requiresAuth: true}
    },
    {
      path: '/roles/:id/edit',
      name: 'roles/edit',
      component: EditRoles,
      meta: {requiresAuth: true}
    },
    {
      path: '/profile/:id/edit',
      name: 'profile/edit',
      component: EditProfile,
      meta: {requiresAuth: true}
    }
  ]
})
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const token = localStorage.getItem('token');

  if (requiresAuth && !token) {
    next('/');
  } else {
    next();
  }
});

export default router
