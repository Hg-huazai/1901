import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  usertext(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=usertext",
      params: params
    }) 
  },
 mytext(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=mytext",
      params: params
    }) 
  },
  mycomment(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=mycomment",
      params: params
    }) 
  },
  commenteditdata(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=commenteditdata",
      params: params
    }) 
  },
  mycommentedit(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=mycommentedit",
      params: params
    }) 
  },
  couponlist(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=couponlist",
      params: params
    }) 
  },
  cashdata(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=cashdata",
      params: params
    }) 
  },
  mycash(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=mycash",
      params: params
    }) 
  },
  myavatar(params)
  {
    return request({
      method:"post",
      url:"/api/usertext.php?action=myavatar",
      params: params
    }) 
  },
}