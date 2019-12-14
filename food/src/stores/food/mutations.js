export default {
  foodlist(state,params)  //直接覆盖
  {
    state.foodlist = params
  },
  loadlist(state,params)  //合并
  {
    state.foodlist = state.foodlist.concat(params)
  },
  hot(state, params)
  {
    state.hot = params
  },
  top(state, params)
  {
    state.top = params
  },
  foodcount(state,params)
  {
    state.foodcount = params
  },
  foodprice(state,params)
  {
    state.foodprice = params
  },
  cartdata(state, params) {
    state.cartdata = params
  }
}