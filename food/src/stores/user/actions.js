//引入请求封装
import proxy from '../../proxy/index'

export default {
  register({commit},registerData)
  {
    return proxy.register(registerData)
  },
  login({commit},loginData)
  {
    return proxy.login(loginData)
  },
  addrAdd({commit},params)
  {
    return proxy.addrAdd(params)
  },
  addrlist({commit},params)
  {
    return proxy.addrlist(params)
  },
  orderaddr({commit},params=null)
  {
    commit('orderaddr',params)
  },
  addrdefault({commit},params=null)
  {
    proxy.addrdefault(params).then(res => {
      if(res.data.result)
      {
        commit("orderaddr",res.data.data)
      }
    })
  },
  orderadd({commit},params=null)
  {
    return proxy.orderadd(params)
  },
  orderlist({commit},params=null)
  {
    return proxy.orderlist(params)
  },
  ordermoudle({commit},params=null)
  {
    return proxy.ordermoudle(params)
  },
  orderreceive({commit},params=null)
  {
    return proxy.orderreceive(params)
  },
  ordercancel({commit},params=null)
  {
    return proxy.ordercancel(params)
  },
  orderagainadd({commit},params=null)
  {
    return proxy.orderagainadd(params)
  },
  ordercomment({commit},params=null)
  {
    return proxy.ordercomment(params)
  },
  ordercoupon({commit},params=null)
  {
    
    commit("ordercoupon",params)
  },
  againordercoupon({commit},params=null)
  {
    
    commit("againordercoupon",params)
  },
  againorderaddr({commit},params=null)
  {
    
    commit("againorderaddr",params)
  },




}