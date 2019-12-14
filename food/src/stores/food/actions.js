//引入请求封装
import proxy from '../../proxy/index'


export default {
  hot({commit})
  {
    return proxy.hot().then(res => {
      let hot = res.data.data.hot
      let top = res.data.data.top

      hot.forEach(item => {
        item.count = 0
      })

      commit("hot", hot)
      commit("top", top)
    })
  },
  catelist({commit})
  {
    return proxy.catelist()
  },
  foodlist({commit},params=null)
  {
    //直接覆盖
    return proxy.foodlist(params).then(res => {
      let foodlist = res.data.data
      foodlist.forEach(item => {
        item.count = 0
      })

      commit('foodlist',foodlist)
    })
  },
  loadlist({ commit }, params = null) 
  {
    //下拉加载
    return proxy.foodlist(params).then(res => {
      let foodlist = res.data.data
      foodlist.forEach(item => {
        item.count = 0
      })

      commit('loadlist', foodlist)
    })
  },
  cartedit({commit},params = null)
  {
    proxy.cartedit(params).then(res => {
      console.log(res.data)
    })
  },
  cartdata({commit},params = null)
  {
    return proxy.cartdata(params).then(res => {
      let foodcount = res.data.data.foodcount
      let foodprice = res.data.data.foodprice
      let cartdata = res.data.data.cartdata
      commit('foodcount', foodcount)
      commit('foodprice', foodprice)
      commit('cartdata', cartdata)
    })
  }
}