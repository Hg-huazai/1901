<template>
<div id="callPhone">
	<div class="callPhone">
			<div class="callPhone1"><img src="/static/img/callphone.png" /></div>
			<div class="callPhone2"><img src="/static/img/callphone1.png" @click="enter" />呼叫服务员</div>
			<div class="callCon">
				您的座位号：<input type="text"/>
			</div>
		</div>
</div>
</template>

<script>
export default {
	name:"mycash",
	
	created(){
	 //触发actions里面叫做menushow这个方法
	  this.$store.dispatch('menushow',true)
	  

 },
  methods:{
     enter(){
			this.$alert("餐厅服务暂无，敬请期待")
	}
  },
  
  
}
 
</script>
<style>

</style>

