<template>
  <el-container>
    <el-main class="main">
      <div class="editAddress">
        <ul v-if="action == 'select'">
          <li @click="select(item)" v-for="(item,key) in addrlist" :key="key">
            <div class="editTitle">
              <p>{{item.name}} {{item.phone}}</p>
              <p class="color000">{{item.address}}</p>
            </div>
            <div class="editPreservation">
              <span @click="locationEdit(item.id)"><img src="/static/img/edit.png"></span>
              <button v-if="item.status == 1">默认</button>
            </div>
          </li>
        </ul>
        <ul v-else-if="action == 'myselect'">
          <li @click="myselect(item)" v-for="(item,key) in addrlist" :key="key">
            <div class="editTitle">
              <p>{{item.name}} {{item.phone}}</p>
              <p class="color000">{{item.address}}</p>
            </div>
            <div class="editPreservation">
              <span @click="locationEdit(item.id)"><img src="/static/img/edit.png"></span>
              <button v-if="item.status == 1">默认</button>
            </div>
          </li>
        </ul>
        <ul v-else>
          <li v-for="(item,key) in addrlist" :key="key">
            <div class="editTitle">
              <p>{{item.name}} {{item.phone}}</p>
              <p class="color000">{{item.address}}</p>
            </div>
            <div class="editPreservation">
              <span @click="locationEdit(item.id)"><img src="/static/img/edit.png"></span>
              <button v-if="item.status == 1">默认</button>
            </div>
          </li>
        </ul>

      </div>
    </el-main>
    <el-footer class="addrfooter">
      <el-row>
        <el-button type="primary" round @click.prevent="locationAddr()">添加收货地址</el-button>
      </el-row>
    </el-footer>
  </el-container>
</template>



<script>
  export default {
    name:"addrlist",
    created(){
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)


      //个人收货地址
      this.$store.dispatch('addrlist',{userid:this.$cookies.get('user').id}).then(res => {
        this.addrlist = res.data.data
      })

      let action = this.$route.query.action ? this.$route.query.action : null
      this.action = action
    },
    data()
    {
      return {
        orderid:this.$route.query.orderid,
        action:null,
        addrlist:[]
      }
    },
    methods:{
      locationAddr()
      {
        this.$router.push('/addradd')
      },
      select(addr)
      {
        this.$store.dispatch('orderaddr',addr)
        this.$router.push('/orderadd')
      },
       myselect(addr)
      {
        this.$store.dispatch('againorderaddr',addr)
        this.$router.push('/orderagain?orderid='+this.orderid)
      },
      locationEdit(id)
      {
        this.$router.push({path:'/addredit',query:{ressid:id}})
      }
    }
  }
</script>


<style>
  .editAddress{
    padding-top:10px!important;
  }
  .addrfooter{
    text-align:center;
  }

  .main{
    padding:0;
  }

  .editPreservation span{
    display: inline-block;
    width:25px;
    height:25px;
  }

  .editPreservation span img{
    width:100%!important;
    height:100%!important;
  }

  .editAddress .editTitle p{
    line-height:1.8!important;
  }

  .editAddress li{
    border-bottom: 1px solid #ccc;
  }

</style>