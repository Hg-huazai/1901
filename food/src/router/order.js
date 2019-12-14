import orderlist from '@/components/orderlist'
import orderadd from '@/components/orderadd'
import ordermoudle from '@/components/ordermoudle'
import orderagain  from '@/components/orderagain'
import ordercomment  from '@/components/ordercomment'

export default [
  {
    path:"/orderlist",
    name:"orderlist",
    component:orderlist
  },
  {
    path:"/orderadd",
    name:"orderadd",
    component:orderadd
  },
  {
    path:"/ordermoudle",
    name:"ordermoudle",
    component:ordermoudle
  },
  {
    path:"/orderagain",
    name:"orderagain",
    component:orderagain
  },
  {
    path:"/ordercomment",
    name:"ordercomment",
    component:ordercomment
  },
]