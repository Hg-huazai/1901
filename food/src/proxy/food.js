import {request} from '../services/request'

export default {
  //将所有请求的接口都封装到一个模块里面
  hot(params=null)
  {
    return request({
      method:"post",
      url:"/api/food.php?action=hot",
      params: params
    })
  },
  catelist(params = null) {
    return request({
      method: "post",
      url: "/api/food.php?action=catelist",
      params: params
    })
  },
  foodlist(params = null) {
    return request({
      method: "post",
      url: "/api/food.php?action=foodlist",
      params: params
    })
  },
  cartedit(params = null)
  {
    return request({
      method:"post",
      url:"/api/food.php?action=cartedit",
      params:params
    })
  },
  cartdata(params = null) {
    return request({
      method: "post",
      url: "/api/food.php?action=cartdata",
      params: params
    })
  }
}