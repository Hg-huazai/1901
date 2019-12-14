export default {
  menushow(state,show)
  {
    //让mutations 去修改 state状态当中 menushow 的变量值 从而组件的效果也会双向变量
    state.menushow = show
  }
}