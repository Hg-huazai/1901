<template>
  <div>
	
    <div class="w100 margin01rem user_avatar">
			<img class="w100" src="/static/img/aboutbanner.png" />
	<router-link to="/useravatar" class="isNext">
      <img class="avatar" :src="userdata.avatar ? userdata.avatar : '/static/img/img-01.jpg'" />
	  </router-link>
		</div>
		
		<ul class="inforList">
      <li>
				<router-link to="/usertext" class="isNext">
					<span><em><img src="/static/img/about4.png"></em>个人信息</span>
					<span></span>
				</router-link>
			</li>
			
      <li>
				<router-link to="/addrlist" class="isNext">
					<span><em><img src="/static/img/about3.png"></em>送餐地址</span>
					<span></span>
				</router-link>
			</li>
      <li>
				<a href="mobile-phone.html" class="isNext">
					<span><em><img src="/static/img/about4.png"></em>用户推荐</span>
					<span></span>
				</a>
			</li>
			<li>
				<router-link to="/coupon" class="isNext">
					<span><em><img style="height: 0.43rem;"  src="/static/img/about2.png"></em>我的优惠券</span>
					<span></span>
				</router-link>
			</li>
			

			<li>
				<router-link to="/myphone" class="isNext">
					
					<span><em><img src="/static/img/about5.png"></em>绑定手机</span>
					<span></span>
				
				</router-link>
				
			</li>

      
      <li>
		  	<router-link to="/mycomment" class="isNext">
					<span><em><img src="/static/img/about4.png"></em>用户评价</span>
					<span></span>
			</router-link>		
	</li>
      <li>
				<router-link to="/mycash" class="isNext">
					<span><em><img src="/static/img/about1.png"></em>余额充值</span>
					<span></span>
				</router-link>		
			</li>
      <li>
				<a @click.prevent="logout()" class="isNext">
					<span><em><img src="/static/img/about4.png"></em>注销</span>
					<span></span>
				</a>
			</li>
		</ul>
  </div>
</template>

<script>
  export default {
    name:"user",
    created()
    {
      //触发actions里面叫做menushow这个方法
	  this.$store.dispatch('menushow',true)
	  
	   this.ressid= this.$cookies.get('user').id

	    this.$store.dispatch('usertext',{ressid:this.ressid}).then(res => {
		 if(res.data.data){
		this.userdata.avatar=this.api+res.data.data.avatar       
        // console.log(this.userdata.avatar)
		 }

      })
    },
    computed:{
      user()
      {
        return this.$cookies.get('user')
      }
    },
    methods:{
      logout()
      {
        this.$cookies.remove('user')
        this.$router.push('/login')
      }
	},
	data(){
		return{
			ressid:0,
			api:"http://localhost:8080/api",
			userdata:{
				avatar:"",
			}
		}
	}
  }
</script>


<style>
  .user_avatar{
    position: relative;
  }
  .avatar{
    width:100px;
    height:100px;
    border-radius: 100%;
    position: absolute;
    left:38%;
    top:25%;
  }
</style>