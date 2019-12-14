<template>
  <div>
    <div class="pay-order-header">
			<ul>
				<li>支付订单</li>
			</ul>
		</div>
		<table width="100%" class="bg-fff order-det-cont" >
			<tbody>
				<tr class="orderaddr" v-if="orderaddr != null" @click="selectAddr()" style="border-bottom: solid 8px #f1f1f1;">
          <td align="left" class="padl3">收货地址</td>
					<td align="right" width="50%">{{orderaddr.address}}</td>	
				</tr>
        <tr class="orderaddr" v-else @click="selectAddr()" style="border-bottom: solid 8px #f1f1f1;">
          <td align="left" class="padl3">收货地址</td>
					<td align="right" width="50%">请选择</td>	
				</tr>
				<tr>
					<td align="left" class="padl3" style="color:#999">商品列表</td>
					<td align="right" width="50%" style="color:#999">更多<img style="width:.3rem;" src="/static/img/jtx1.png" /></td>	
				</tr>
				<tr v-for="(item,key) in orderuser" :key="key">
          <td colspan="3" class="foodlist">
            <div>{{item.name}}</div> 
            <div>×<em>{{item.foodnum}}</em></div>
            <div>￥{{item.foodprice}}</div>
          </td>
				</tr>
				<tr>
					<td align="left" colspan="1" class="padl3">商品总额</td>
					<td align="right" class="padr3">￥<em>{{foodprice}}</em></td>
				</tr>		
        <tr  @click="selectcoupon()">
          	<td align="left" colspan="1" class="padl3">优惠券</td>
            <td align="right" class="padr3">￥<em>{{cash}}</em></td>
        </tr>		
				<tr style="border-top: solid 8px #f1f1f1;">
					<td align="left" colspan="1" class="padl3">实付金额:</td>
					<td align="right" class="padr3">
						<a class="padding-right23 colorf00">￥{{foodprice>cash?foodprice-cash:0}}</a>
					</td>
				</tr>			
			</tbody>
		</table>
		
		<div style="height:1rem;"></div>
		<div class="order-set-paybutton">
      <router-link class="paybutton-left fl" style="width: 40%;text-align: center;" to="/orderlist">
          取消
      </router-link>
			<div class="paybutton-right fr" style="width: 60%;text-align: center;">
        <a @click="orderadd()">确认订单</a>
      </div>
			<div class="clearfix"></div>
		</div>

    <div id="datePlugin"></div>
  </div>
</template>

<script>
  export default {
    name:"orderagain",
     data()
    {
      return{
         cash:0,
        couponid:0,
         orderid:0,
         ordermoudle:[],
         orderaddress:[],
        orderuser:[],
        foodcount:"",
        foodprice:"",
      }  
    },
    created()
    {
      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',false)

      // //获取购物车数据
      // this.$store.dispatch('cartdata',{userid:this.$cookies.get('user').id});

       this.orderid=this.$route.query.orderid;
      // 获取订单数据
      this.$store.dispatch('ordermoudle',{userid:this.$cookies.get('user').id,orderid: this.orderid}).then(res => {
          if(res.data.data)
          {
            this.ordermoudle=res.data.data.ordermoudle,
            this.orderaddress=res.data.data.orderaddress,
            this.orderuser=res.data.data.orderuser,
            this.foodcount=res.data.data.foodcount,
            this.foodprice=res.data.data.foodprice
          
            // console.log(res.data.data)
          // }else{
          //   this.$alert(res.data.msg)
          }
        })

      //获取用户的默认收货地址
      if(!this.$store.state.user.orderaddr)
      {
        this.$store.dispatch('addrdefault',{userid:this.$cookies.get('user').id})
      }

        // 先判断是否为空，不然.cssh会报错。
      if(this.$store.state.user.againordercoupon!=null){
         this.cash=this.$store.state.user.againordercoupon.cash;
         this.couponid=this.$store.state.user.againordercoupon.id;
         console.log(this.couponid);
      }    
    },
    computed:{
      // cartdata()
      // {
      //   return this.$store.state.food.cartdata
      // },
      // foodprice()
      // {
      //   return this.$store.state.food.foodprice
      // // },
      orderaddr()
      {
        return this.$store.state.user.orderaddr
      }
    },
    methods:{
      
      selectAddr()
      {
        this.$router.push({path:'/addrlist',query:{action:"myselect",orderid:this.$route.query.orderid}})
      },

       // 优惠券
      selectcoupon()
      {
        this.$router.push({path:'/coupon',query:{action:"againseltct",orderid:this.$route.query.orderid}})
      },
      
      orderadd()
      {
        let data = {
          userid:this.$cookies.get('user').id,
         orderid:this.$route.query.orderid,
         addrid:this.$store.state.user.againorderaddr.id,
         couponid:this.couponid,
        }
        this.$store.dispatch('orderagainadd',data).then(res => {
          if(res.data.result)
          {
            this.$alert(res.data.msg).then(result => {
               this.$router.push('/orderlist')
               this.cash=0;
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
  .order-det-cont td.foodlist{
    column-count:3!important;
    column-width: 300px;
  }

  .order-det-cont td.foodlist div{
    display: inline-block;
    width:100px;
  }

  .orderaddr td:last-child{
    white-space: nowrap;
    text-overflow: ellipsis;
  }
</style>