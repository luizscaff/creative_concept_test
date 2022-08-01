import Vue from 'vue'
import Router from 'vue-router'

import Login from '@/views/auth/Login'

import Home from '@/views/index/Home'
import Tasks from '@/views/index/Tasks'
import Users from '@/views/index/Users'

import TaskCreate from '@/views/edit/Tasks'
import UserCreate from '@/views/edit/Users'

import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'

Vue.use(Router)

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/home',
      name: 'Home',
      component: Home,
      beforeEnter: protectedRoute
    },
    {
      path: '/tasks',
      name: 'Tasks',
      component: Tasks,
      beforeEnter: protectedRoute
    },
    {
      path: '/users',
      name: 'Users',
      component: Users,
      beforeEnter: protectedRoute
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/tasks/create',
      name: 'Tasks.create',
      component: TaskCreate,
      beforeEnter: protectedRoute
    },
    {
      path: '/tasks/:id/edit',
      name: 'Tasks.edit',
      component: TaskCreate,
      beforeEnter: protectedRoute
    },
    {
      path: '/users/create',
      name: 'Users.create',
      component: UserCreate,
      beforeEnter: protectedRoute
    },
    {
      path: '/users/:id/edit',
      name: 'Users.edit',
      component: UserCreate,
      beforeEnter: protectedRoute
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      redirect: '/home',
      beforeEnter: protectedRoute
    }
  ]
})

function protectedRoute(to, from, next) {
  var isAuthenticated= false;

  if(sessionStorage.getItem('user'))
    isAuthenticated = true;
  else
    isAuthenticated= false;
  if(isAuthenticated) 
  {
    next();
  } 
  else
  {
    next('/login');
  }
}
