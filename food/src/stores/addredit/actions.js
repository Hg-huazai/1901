//引入请求封装
import proxy from '../../proxy/index'


export default {
  addredit({commit},ressidData)
  {
    return proxy.addredit(ressidData)
  },
  edit({commit},editData)
  {
    return proxy.edit(editData)
  }
}