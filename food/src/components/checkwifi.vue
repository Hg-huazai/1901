<template>
<el-container>
   
		<div class="wifiCon">
			<img src="/static/img/bg.png" />
			<h1>WiFi无忧险</h1>
			<p>轻松上网放心支付</p>
		</div>
	</el-container>
</template>

<script>
export default {
	name:"checkwifi",
	
	created(){
	 //触发actions里面叫做menushow这个方法
	  this.$store.dispatch('menushow',true)	  
 },
 
  
}
 
</script>


