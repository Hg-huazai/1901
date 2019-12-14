<template>
  <div class="limiter">
    <div class="container-login100" style="background-image: url('/static/img/img-01.jpg');">
        <div class="wrap-login100 p-t-190 p-b-30">
            <form class="login100-form validate-form" @submit.prevent="register()">
                <div class="login100-form-avatar">
                    <img src="/static/img/avatar-01.jpg" alt="AVATAR">
                </div>

                <span class="login100-form-title p-t-20 p-b-45">注册</span>

                <div class="wrap-input100 validate-input m-b-10" data-validate="请输入用户名">
                    <input class="input100" type="text" v-model="user.username" placeholder="用户名" autocomplete="off">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-user"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input m-b-10" data-validate="请输入密码">
                    <input class="input100" type="password" name="password" placeholder="密码" v-model="user.password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn p-t-10">
                    <button type="submit" class="login100-form-btn">注册</button>
                </div>

                <div class="text-center w-full p-t-25 p-b-230">
                    <router-link to="/login" class="txt1">登录</router-link>
                </div>

                <div class="text-center w-full">
                    <a class="txt1" href="index.html#">
                        立即注册
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
    name:"register",
    created()
    {
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',false)

      //判断如果有cookie 就直接回到会员中心
      if(this.$cookies.get('user'))
      {
        this.$router.push('/user')
        return false
      }

    },
    data()
    {
      return {
        user:{
        }
      }
    },
    methods:{
      register()
      {
        this.$store.dispatch('register',this.user).then(res => {
          if(res.data.result)
          {
            this.$alert(res.data.msg).then(result => {
              this.$router.push("/login")
            })
          }else{
            this.$alert(res.data.msg)
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