import home from '@/components/home'
import login from '@/components/login'
import register from '@/components/register'

export default [
  {
    path: '/',
    name: 'home',
    component: home,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path:"/login",
    name:"login",
    component:login
  },
  {
    path: "/register",
    name: "register",
    component: register
  },
]