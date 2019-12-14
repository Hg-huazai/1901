import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)


//引入各大路由文件
import home from './home'  //点餐模块
import order from './order'  //订单模块
import services from './services' //服务模块
import user from './user'  //会员模块

export default new Router({
  routes: [
    ...home,
    ...order,
    ...services,
    ...user
  ]
})
