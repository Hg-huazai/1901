<template>
<div>
	 <el-tabs v-model="activeName" @tab-click="couponChange" >
      <el-tab-pane  label="未使用" name="1" >
       <ul  v-if="action == 'myseltct'">
				<li  @click="select(item)" class="coupon-list " v-for="(item,key) in couponlist" :key="key">
					
						<div class="fl coupon-left"  >
							<h1 class="f05 fl line-height14 colorfff">¥<em>{{item.cash}}</em></h1>
							<h2 class="f032 fl colorfff mt10 ml5 line-height-02rem">
								YUAN</br>优惠券
							</h2>
						</div>
						<div class="fr coupon-right f028 ">
							<p>1.{{item.content}}</p>
							<p>2.有限期至：{{item.enddate |  formatDate}}</p>
						</div>
					
				</li>				
			</ul>
			<ul  v-else-if="action == 'againseltct'">
				<li  @click="againselect(item)" class="coupon-list " v-for="(item,key) in couponlist" :key="key">
					
						<div class="fl coupon-left"  >
							<h1 class="f05 fl line-height14 colorfff">¥<em>{{item.cash}}</em></h1>
							<h2 class="f032 fl colorfff mt10 ml5 line-height-02rem">
								YUAN</br>优惠券
							</h2>
						</div>
						<div class="fr coupon-right f028 ">
							<p>1.{{item.content}}</p>
							<p>2.有限期至：{{item.enddate |  formatDate}}</p>
						</div>
					
				</li>				
			</ul>
			<ul v-else>
				<li class="coupon-list"  v-for="(item,key) in couponlist" :key="key">
					<a href="javascript:void(0)" class="clearfix">
						<div class="fl coupon-left" >
							<h1 class="f05 fl line-height14 colorfff">¥<em>{{item.cash}}</em></h1>
							<h2 class="f032 fl colorfff mt10 ml5 line-height-02rem">
								YUAN</br>优惠券
							</h2>
						</div>
						<div class="fr coupon-right f028 ">
							<p>1.{{item.content}}</p>
							<p>2.有限期至：{{item.enddate |  formatDate}}</p>
						</div>
					</a>
				</li>	
			</ul>
      </el-tab-pane>
      <el-tab-pane  label="已使用" name="2">
        <ul>
				<li class="coupon-list"  v-for="(item,key) in couponlist" :key="key">
					<a href="javascript:void(0)" class="clearfix">
						<div class="fl coupon-left">
							<h1 class="f05 fl line-height14 colorfff">¥<em>{{item.cash}}</em></h1>
							<h2 class="f032 fl colorfff mt10 ml5 line-height-02rem">
								YUAN</br>优惠券
							</h2>
						</div>
						<div class="fr coupon-right f028 ">
							<p>1.{{item.content}}</p>
							<p>2.有限期至：{{item.enddate |  formatDate}}</p>
						</div>
						<div class="syImg"><img src="/static/img/sy.png" /></div>
					</a>
				</li>

				
			</ul>
      </el-tab-pane>
      <el-tab-pane  label="已过期" name="3">
        <ul>
				<li class="coupon-list" v-for="(item,key) in couponlist" :key="key">
					<a href="javascript:void(0)" class="clearfix">
						<div class="fl coupon-left">
							<h1 class="f05 fl line-height14 colorfff">¥<em>{{item.cash}}</em></h1>
							<h2 class="f032 fl colorfff mt10 ml5 line-height-02rem">
								YUAN</br>优惠券
							</h2>
						</div>
						<div class="fr coupon-right f028 ">
							<p>1.{{item.content}}</p>
							<p>2.有限期至：{{item.enddate |  formatDate}}</p>
						</div>
						<div class="syImg"><img src="/static/img/gq.png" /></div>
					</a>
				</li>
			
			</ul>
      </el-tab-pane>
    </el-tabs>
</div>
</template>

<script>
import moment from 'moment'
export default {
	name:"coupon",
	created(){
	 //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)


      // 一进来给他数据
     this.$store.dispatch('couponlist',{status:1,userid:this.$cookies.get('user').id}).then(res => {
		 if(res.data.data){
		this.couponlist=res.data.data       
        // console.log(this.couponlist)
		 }

	  })
	  
	   let action = this.$route.query.action ? this.$route.query.action : null
      this.action = action
 },
  methods:{
	  couponChange(tab)
      {
        this.activeName = tab.name
        this.$store.dispatch('couponlist',{status:tab.name,userid:this.$cookies.get('user').id}).then(res => {
            this.couponlist = res.data.data
        })
	  },
	  select(cou)
      {
		//   console.log(1111)
		  //优惠券
        this.$store.dispatch('ordercoupon',cou)
        this.$router.push('/orderadd')
	  },
	   againselect(cou)
      {
		//   console.log(1111)
		  //优惠券
        this.$store.dispatch('againordercoupon',cou)
        this.$router.push('/orderagain?orderid='+this.orderid)
      },
    
  },
  data(){
	  return{
		  orderid:this.$route.query.orderid,
		   action:null,
		activeName:"1",
        couponlist:[],
	 }
  },
   filters:{
      formatDate(value)
      {
        return moment(value*1000).format('YYYY-MM-DD')
      }
	},
}
 
</script>
<style>
  .addrfooter{
    text-align:center;
  }

  .main{
    padding:0;
  }

  label{
	  position:relative;
  }

  .choose{
	  width:71%!important;
  }

  .el-tabs--top .el-tabs__item.is-top:nth-child(2) {
	  padding-left:21px;
  }

  .coupon-list a{
	  margin-bottom: 10px;
  }

  .coupon-list img {
	  width: 88%;
  }

  /* .addmargin0 .addmargin1{
	padding-left:80px!important;
  } */
</style>

