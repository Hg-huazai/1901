<template>
  <nav class="menu" v-show="menushow">
    <router-link to="/" class="homeIcon" exact active-class="addclasstruenav homeIconActive">
        点餐
    </router-link>
    <router-link to="/orderlist" class="categoryIcon" active-class="addclasstruenav categoryIconActive">
        订单
    </router-link>
    <router-link to="/service" class="cartIcon numberCount" active-class="addclasstruenav cartIconActive">
        服务
    </router-link>
    <router-link to="/user" class="userIcon" active-class="addclasstruenav userIconActive">
        我的
    </router-link>
  </nav>
</template>

<script>
  export default {
    name:"menulist",
    created()
    {
      //初始化后触发的钩子
      //获取vuex common模块里面的 menushow 状态
      //console.log(this.$store.state.common.menushow);
    },
    computed:{
      menushow()
      {
        return this.$store.state.common.menushow
      }
    }
  }
</script>

<style>
  .tab {top: 0;}
  .my-order-iphone1 {margin-top: 4%;}
  .addclasstruenav{color: #3acd17!important;}

  .menu{
    z-index:10;
  }
  .menu a{
    width:95px;
    height:50px;
    line-height:60px;
  }

  .menu .homeIcon{
    background:url('/static/img/index1.png') no-repeat center top;
    background-size:22%;
  }

  .menu .homeIconActive{
    background:url('/static/img/index1-1.png') no-repeat center top;
    background-size:22%;
  }

  .menu .categoryIcon{
    background:url('/static/img/index2.png') no-repeat center top;
    background-size:22%;
  }

  .menu .categoryIconActive{
    background:url('/static/img/index2-1.png') no-repeat center top;
    background-size:22%;
  }

  .menu .cartIcon{
    background:url('/static/img/index3.png') no-repeat center top;
    background-size:22%;
  }

  .menu .cartIconActive{
    background:url('/static/img/index3-1.png') no-repeat center top;
    background-size:22%;
  }

  .menu .userIcon{
    background:url('/static/img/index4.png') no-repeat center top;
    background-size:22%;
  }

  .menu .userIconActive{
    background:url('/static/img/index4-1.png') no-repeat center top;
    background-size:22%;
  }
</style>