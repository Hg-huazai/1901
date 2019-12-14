import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  province(params=null)
  {
    return request({
      method:"post",
      url:"/api/city.php?action=province",
      params: params
    })
  },
  city(params = null) {
    return request({
      method: "post",
      url: "/api/city.php?action=city",
      params: params
    })
  },
  area(params = null) {
    return request({
      method: "post",
      url: "/api/city.php?action=area",
      params: params
    })
  },
}