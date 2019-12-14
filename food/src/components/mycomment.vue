<template>
  <el-container>
    <el-main class="main">
      <div class="editAddress">
        <ul >
          <li  v-for="(item,key) in commentlist" :key="key">
            <div class="editTitle">
              <p>订单：{{item.id}} 时间：{{item.createtime | formatDate}}</p>
              <p>评论内容：{{item.content}}</p>
              <p class="color000"><el-rate v-model="item.level"  show-text disabled></el-rate></p>
            </div>
            <div class="editPreservation">
              <span @click="locationEdit(item.id)"><img src="/static/img/edit.png"></span>
              <!-- <button v-if="item.status == 1">默认</button> -->
            </div>
          </li>
        </ul>
      </div>
    </el-main>
    <!-- <el-footer class="addrfooter">
      <el-row>
        <el-button type="primary" round @click.prevent="locationAddr()">添加收货地址</el-button>
      </el-row>
    </el-footer> -->
  </el-container>
</template>



<script>
import moment from 'moment'
  export default {
    name:"mycomment",
    created(){
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)


      //个人评论
      this.$store.dispatch('mycomment',{userid:this.$cookies.get('user').id}).then(res => {
        this.commentlist = res.data.data
       
      })

      let action = this.$route.query.action ? this.$route.query.action : null
      this.action = action
    },
    data()
    {
      return {
        value:null,
        
        action:null,
        commentlist:{},
      }
    },
    methods:{
 
      locationEdit(id)
      {
        this.$router.push({path:'/mycommentedit',query:{commentid:id}})
      }
    },
    filters:{
      formatDate(value)
      {
        return moment(value*1000).format('YYYY-MM-DD HH:mm')
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