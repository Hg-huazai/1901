//引入
import Vue from 'vue'
import Vuex from 'vuex'

//挂载
Vue.use(Vuex)

//引入各大模块
import common from './common'   //公共模块
import user from './user'      //用户模块
import food from './food'      //食品模块
import addredit from './addredit'      //编辑地址模块
import usertext from './usertext'      //个人信息模块

//创建一个状态管理的对象
export default new Vuex.Store({
  modules:{
    user,
    common,
    food,
    addredit,
    usertext
  }
})