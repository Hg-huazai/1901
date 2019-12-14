<template>
  <div>
    <el-tabs v-model="activeName" @tab-click="orderChange">
      <el-tab-pane label="已支付" name="1">
        <ul>
          <li v-for="(item,key) in orderlist" :key="key" class="bor-bottom5-f1 bg-fff padb03">
            <div class="order-details-header" @click="linkmodule(item.id)">
              <div class="order-det-logo fl"><img src="/static/img/logo.jpg.png"></div>
              <div class="order-det-time fl">
                <h4>{{item.ordersn}}</h4>
                <p>{{item.createtime | formatDate}}</p>
              </div>
              <div class="my-order-iphone1 fr f032 text-right">
                <h4 class="f029">￥{{item.price}}</h4>
                <p class="f02 color999">备注：{{item.content}}</p>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="bg-fff pay-button-myorder" style="text-align:right">
              <el-button type="danger" @click="cancel(item.id)">取消</el-button>
              <el-button type="primary" @click="receive(item.id)">确认收货</el-button>
            </div>
          </li>
        </ul>
      </el-tab-pane>
      <el-tab-pane label="已收货" name="2">
        <ul>
          <li v-for="(item,key) in orderlist" :key="key" class="bor-bottom5-f1 bg-fff padb03">
            <div class="order-details-header"  @click="linkmodule(item.id)">
              <div class="order-det-logo fl"><img src="/static/img/logo.jpg.png"></div>
              <div class="order-det-time fl">
                <h4>{{item.ordersn}}</h4>
                <p>{{item.createtime | formatDate}}</p>
              </div>
              <div class="my-order-iphone1 fr f032 text-right">
                <h4 class="f029">￥{{item.price}}</h4>
                <p class="f02 color999">备注：{{item.content}}</p>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="bg-fff pay-button-myorder" style="text-align:right">
              <el-button type="warning" @click="again(item.id)">再来一单</el-button>
              <el-button type="primary" @click="comment(item.id)">立即评价</el-button>
            </div>
          </li>
        </ul>
      </el-tab-pane>
      <el-tab-pane label="已完成" name="3">
        <ul>
          <li v-for="(item,key) in orderlist" :key="key" class="bor-bottom5-f1 bg-fff padb03">
            <div class="order-details-header">
              <div class="order-det-logo fl"><img src="/static/img/logo.jpg.png"></div>
              <div class="order-det-time fl">
                <h4>{{item.ordersn}}</h4>
                <p>{{item.createtime | formatDate}}</p>
              </div>
              <div class="my-order-iphone1 fr f032 text-right">
                <h4 class="f029">￥{{item.price}}</h4>
                <p class="f02 color999">备注：{{item.content}}</p>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="bg-fff pay-button-myorder" style="text-align:right">
              <el-button type="primary" @click="linkmodule(item.id)">查看订单详情</el-button>
            </div>
          </li>
        </ul>
      </el-tab-pane>
      <el-tab-pane label="已取消" name="0">
        <ul>
          <li v-for="(item,key) in orderlist" :key="key" class="bor-bottom5-f1 bg-fff padb03">
            <div class="order-details-header">
              <div class="order-det-logo fl"><img src="/static/img/logo.jpg.png"></div>
              <div class="order-det-time fl">
                <h4>{{item.ordersn}}</h4>
                <p>{{item.createtime | formatDate}}</p>
              </div>
              <div class="my-order-iphone1 fr f032 text-right">
                <h4 class="f029">￥{{item.price}}</h4>
                <p class="f02 color999">备注：{{item.content}}</p>
              </div>
              <div class="clearfix"></div>
            </div>
          </li>
        </ul>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>


<script>
  import moment from 'moment'
  export default {
    name:"orderlist",
    inject: ['reload'],
    created()
    {
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)

      this.$store.dispatch('orderlist',{status:1,userid:this.$cookies.get('user').id}).then(res => {
          this.orderlist = res.data.data
        })
    },
    data(){
      return {
        activeName:"1",
        orderlist:[],
      }
    },
    methods:{
      orderChange(tab)
      {
        this.activeName = tab.name
        this.$store.dispatch('orderlist',{status:tab.name,userid:this.$cookies.get('user').id}).then(res => {
            this.orderlist = res.data.data
        })
      },
      // 查看订单
      linkmodule(mid)
      {
        this.$router.push({path:'/ordermoudle',query:{orderid:mid}})
      },
      // 确认收货
      receive(rid)
      {
        this.$store.dispatch("orderreceive",{orderid:rid}).then(res=>{
          this.$alert(res.data.msg).then(res => {
              this.reload()
            })
        })
      },
      //取消订单
      cancel(cid){
        this.$store.dispatch("ordercancel",{orderid:cid}).then(res=>{
           this.$alert(res.data.msg).then(res => {
              this.reload()
            })
        })
      },
      // 再来一单
      again(aid){
         this.$router.push({path:'/orderagain',query:{orderid:aid}})
      },
      // 订单评价
      comment(cid){
         this.$router.push({path:'/ordercomment',query:{orderid:cid}})
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
  .el-tabs__item{
    width:85px!important;
    text-align:center;
  }
</style>