import service from '@/components/service'
import checkwifi from '@/components/checkwifi'
import tableware from '@/components/tableware'
import zuowei from '@/components/zuowei'
import waiter from '@/components/waiter'
import invoice from '@/components/invoice'

export default [
  {
    path:"/service",
    name:"service",
    component: service
  },
  {
    path:"/checkwifi",
    name:"checkwifi",
    component: checkwifi,
    meta:{  //自定义属性
      requireAuth:true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path:"/tableware",
    name:"tableware",
    component: tableware,
    meta:{  //自定义属性
      requireAuth:true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path:"/zuowei",
    name:"zuowei",
    component: zuowei,
    meta:{  //自定义属性
      requireAuth:true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path:"/waiter",
    name:"waiter",
    component:waiter,
    meta:{  //自定义属性
      requireAuth:true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path:"/invoice",
    name:"invoice",
    component:invoice,
    meta:{  //自定义属性
      requireAuth:true, //如果这个属性为true 就代表必须要登录
    }
  },

]