import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  register(params)
  {
    return request({
      method:"post",
      url:"/api/user.php?action=register",
      params: params
    })
  },
  login(params) {
    return request({
      method: "post",
      url: "/api/user.php?action=login",
      params: params
    })
  }
}