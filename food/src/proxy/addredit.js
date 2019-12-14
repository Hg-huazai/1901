import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  addredit(params)
  {
    return request({
      method:"post",
      url:"/api/addredit.php?action=addredit",
      params: params
    })
  },
  edit(params)
  {
    return request({
      method:"post",
      url:"/api/addredit.php?action=edit",
      params: params
    })
  },
}