import axios from 'axios'
import QS from 'qs'

//设置超时时间
axios.defaults.timeout = 10000

// post请求头
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';

export function request({method,url,params})
{
  if (method == 'get')
  {
    return get(url, params)
  }else{
    return post(url, params)
  }
}

//封装get
function get(url,params)
{
  return new Promise((resolve, reject) => {
    axios.get(url,params).then(res => {
      resolve(res.data)
    }).catch(err => {
      reject(false)
    })
  })
}

//封装post
function post(url,params)
{
  return new Promise((resolve,reject) => {
    axios.post(url, QS.stringify(params)).then(res => {
      resolve(res)
    }).catch(err => {
      reject(false)
    })
  })
}