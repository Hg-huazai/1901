<template>
  <el-container>
    <el-main class="main">
      <ul class="formarea">
        <li>
          <label class="lit">姓名</label>
          <input type="text" v-model="address.name" placeholder="请输入您的姓名" class="textbox" />
        </li>
        <li>
          <label class="lit">手机号码</label>
          <input type="text" v-model="address.phone" placeholder="请输入您的手机号码" class="textbox" />
        </li>
        <li>
          <label class="lit">详细地址</label>
          <input type="text" v-model="address.address" placeholder="请输入您的详细地址" class="textbox" />
        </li>
        <li>
          <label class="lit">设置默认</label>
          <el-switch
            v-model="address.status"
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-value=1
            inactive-value=0
            class="status">
          </el-switch>
        </li>
        <addr @change="addr" class="addr"></addr>
      </ul>
      <div style="height:1.2rem;"></div>
      <div class="button-order-det" @click="add()">确认</div>
    </el-main>
  </el-container>
</template>



<script>
  import addr from '@/components/address.vue'
  export default {
    name:"addrlist",
    components:{
      addr
    },
    created(){
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',false)
      this.$store.dispatch('province').then(res => {
        this.provinces = res.data.data
      })
    },
    data() {
      return {
        address:{
          city:"",
          area:"",
          userid:0,
        }
      }
    },
    methods:{
      addr(region)
      {
        this.address.province = region.province
        this.address.city = region.city
        this.address.area = region.area
      },
      add()
      {
        this.address.userid = this.$cookies.get('user').id
        this.$store.dispatch('addrAdd',this.address).then(res => {
          if(res.data.result)
          {
            this.$alert(res.data.msg).then(result => {
              this.$router.push('/addrlist')
            })
          }else{
            this.$alert(res.data.msg)
          }
        })
      }
    }
  }
</script>


<style>
  .addrfooter{
    text-align:center;
  }

  .main{
    padding:0;
  }

  .status{
    width: 25%;
    padding: .46rem 6%;
    border: none;
    margin-left: 1.5rem;
  }

  .address{
    width: 75%;
    padding: .1rem 6%;
    border: none;
    margin-left: 1.5rem;
  }

  .addr{
    background:#fff;
  }
</style>