import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  orderadd(params=null)
  {
    return request({
      method:"post",
      url:"/api/order.php?action=orderadd",
      params: params
    })
  },
  orderlist(params=null)
  {
    return request({
      methods:"post",
      url:"/api/order.php?action=orderlist",
      params:params
    })
  },
  ordermoudle(params=null)
  {
    return request({
      methods:"post",
      url:"/api/order.php?action=ordermoudle",
      params:params
    })
  },
  // 确认收货
  orderreceive(params=null)
  {
    return request({
      methods:"post",
      url:"/api/order.php?action=orderreceive",
      params:params
    })
  },
  // 取消订单
  ordercancel(params=null)
  {
    return request({
      methods:"post",
      url:"/api/order.php?action=ordercancel",
      params:params
    })
  },
    // 再来一单
    orderagainadd(params=null)
    {
      return request({
        methods:"post",
        url:"/api/order.php?action=orderagainadd",
        params:params
      })
    },
      // 评论
      ordercomment(params=null)
      {
        return request({
          methods:"post",
          url:"/api/order.php?action=ordercomment",
          params:params
        })
      } ,
       ordercoupon(params=null)
      {
        return request({
          method:"post",
          url:"/api/order.php?action=ordercoupon",
          params: params
        })
      },
      againordercoupon(params=null)
      {
        return request({
          method:"post",
          url:"/api/order.php?action=againordercoupon",
          params: params
        })
      },
      againorderaddr(params=null)
      {
        return request({
          method:"post",
          url:"/api/order.php?action=againorderaddr",
          params: params
        })
      },

}