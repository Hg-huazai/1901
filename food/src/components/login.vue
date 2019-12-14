<template>
  <div class="limiter">
    <div class="container-login100" style="background-image: url('/static/img/img-01.jpg');">
        <div class="wrap-login100 p-t-190 p-b-30">
            <form class="login100-form validate-form" @submit.prevent="login()">
                <div class="login100-form-avatar">
                    <img src="/static/img/avatar-01.jpg" alt="AVATAR">
                </div>

                <span class="login100-form-title p-t-20 p-b-45">登录</span>

                <div class="wrap-input100 validate-input m-b-10" data-validate="请输入用户名">
                    <input class="input100" type="text" name="username" placeholder="用户名" autocomplete="off" v-model="user.username">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-user"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input m-b-10" data-validate="请输入密码">
                    <input class="input100" type="password" name="pass" placeholder="密码" v-model="user.password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn p-t-10">
                    <button class="login100-form-btn">登 录</button>
                </div>

                <div class="text-center w-full p-t-25 p-b-230">
                    <router-link to="/register" class="txt1">注册</router-link>
                </div>

            </form>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:"login",
    created()
    {
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',false)

      if(this.$cookies.get('user'))
      {
        this.$router.push('/user')
        return false
      }
    },
    data()
    {
      return {
        user:{}
      }
    },
    methods:{
      login()
      {
        this.$store.dispatch('login',this.user).then(res => {
          let user = res.data
          if(user.result)
          {
            //登录成功
            this.$cookies.set("user",user.data)  //设置cookie
            this.$alert(user.msg).then(result => {
              this.$router.push('/user')
            })
          }else{
            this.$alert(user.msg)
          }
        })
      }
    }
  }
</script>

<style scoped>
  @import '../../static/fonts/font-awesome-4.7.0/css/font-awesome.min.css';
  @import '../../static/css/util.css';
  @import '../../static/css/main.css';
</style>