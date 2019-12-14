import proxy from '../../proxy/index'
export default {
  menushow({ commit }, show)
  {
    //让actions 去触发 mutations 修改
    commit('menushow',show)
  },
  province({commit})
  {
    return proxy.province()
  },
  city({commit},params)
  {
    return proxy.city(params)
  },
  area({ commit }, params) {
    return proxy.area(params)
  }
}