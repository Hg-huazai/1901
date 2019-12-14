import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  addrAdd(params)
  {
    return request({
      method:"post",
      url:"/api/address.php?action=add",
      params: params
    })
  },
  addrlist(params = null)
  {
    return request({
      method:"post",
      url:"/api/address.php?action=list",
      params:params
    })
  },
  addrdefault(params = null) {
    return request({
      method: "post",
      url: "/api/address.php?action=addrdefault",
      params: params
    })
  },
}