import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  address(params)
  {
    return request({
      method:"post",
      url:"/api/addrlist.php?action=address",
      params: params
    })
  },
}