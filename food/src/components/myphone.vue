<template>
<el-container>
    <el-main class="main">
		<ul class="formarea mobile-phone">
			<li>
				<label class="lit">手机号：</label>
				<input type="text" placeholder="请输入手机号" class="textbox" />
			</li>
			<li>
				<label class="lit">验证码：</label>
				<input type="password" placeholder="请输入验证码" class="textbox" />
				<button class="yanzhegma">获取验证码</button>
			</li>
		</ul>
		</el-main>
		<el-footer class="addrfooter">
			<el-row>
			<el-button type="success"    @click.prevent="locationenter()">绑定</el-button>
			</el-row>
		</el-footer>
	</el-container>
</template>

<script>
export default {
	name:"myphone",
	created(){
	 //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)
 },
  methods:{
      locationenter()
      {
		
		this.$alert('暂不能绑定')

	  },
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
</style>

