import user from "@/components/user"
import addrlist from "@/components/addrlist"
import addradd from "@/components/addradd"
import addredit from "@/components/addredit"
import usertext from "@/components/usertext"
import mycomment from "@/components/mycomment"
import mycommentedit from "@/components/mycommentedit"
import myphone from "@/components/myphone"
import coupon from "@/components/coupon"
import mycash from "@/components/mycash"
import useravatar from "@/components/useravatar"


export default [
  {
    path:"/user",
    name:"user",
    component:user,
    meta:{  //自定义属性
      requireAuth:true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/addrlist",
    name: "addrlist",
    component: addrlist,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/addradd",
    name: "addradd",
    component: addradd,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/addredit",
    name: "addredit",
    component: addredit,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/usertext",
    name: "usertext",
    component: usertext,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/mycomment",
    name: "mycomment",
    component: mycomment,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/mycommentedit",
    name: "mycommentedit",
    component: mycommentedit,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/myphone",
    name: "myphone",
    component: myphone,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  //优惠券
  {
    path: "/coupon",
    name: "coupon",
    component: coupon,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/mycash",
    name: "mycash",
    component: mycash,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },
  {
    path: "/useravatar",
    name: "useravatar",
    component: useravatar,
    meta: {  //自定义属性
      requireAuth: true, //如果这个属性为true 就代表必须要登录
    }
  },


]