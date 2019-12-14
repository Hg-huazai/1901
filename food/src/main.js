import Vue from 'vue'
import App from './App'
import router from './router'
import store from './stores'


//引入第三方组件

//引入ElementUI 框架
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

//第三方的http请求模块
import axios from 'axios'
import VueAxios from 'vue-axios'

//使用第三方的弹框插件
import { Alert, Confirm, Toast, Loading } from 'wc-messagebox'
import 'wc-messagebox/style.css'

//引入cookie
import VueCookies from 'vue-cookies'

//引入轮播图插件
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'

//引入滚动插件
import VueScroller from 'vue-scroller'

//挂载应用
Vue.use(ElementUI)

//挂载http库
Vue.use(VueAxios, axios)

//挂载cookie
Vue.use(VueCookies)


//挂载弹框
Vue.use(Alert)
Vue.use(Confirm)
Vue.use(Toast, 3000)
Vue.use(Loading)

//挂载轮播图插件
Vue.use(VueAwesomeSwiper)


//挂载插件
Vue.use(VueScroller)


Vue.config.productionTip = false


//全局判断路由  在所有路由被挂载之前循环
router.beforeEach((to,from,next) => {
  if (to.meta.requireAuth)  //判断添加的自定义属性是否为true
  {
    //判断是否有cookie
    var user = VueCookies.get('user')
    if(user)
    {
      //如果有cookie 
      next()
    }else{
      next('/login')
    }
  }else{
    next()
  }
})


/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
