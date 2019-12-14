//引入请求封装
import proxy from '../../proxy/index'


export default {
  usertext({commit},myData)
  {
    return proxy.usertext(myData)
  },
  mytext({commit},myuserData)
  {
    return proxy.mytext(myuserData)
  },
    // 用户评论列表
  mycomment({commit},params=null)
  {
    return proxy.mycomment(params)
  },
  commenteditdata({commit},params=null)
  {
    return proxy.commenteditdata(params)
  },
  mycommentedit({commit},params=null)
  {
    return proxy.mycommentedit(params)
  },
  // 优惠券
  couponlist({commit},params=null)
  {
    return proxy.couponlist(params)
  },
  // 余额充值
  cashdata({commit},params=null)
  {
    return proxy.cashdata(params)
  },
  mycash({commit},params=null)
  {
    return proxy.mycash(params)
  },
  myavatar({commit},params=null)
  {
    return proxy.myavatar(params)
  },
 
}