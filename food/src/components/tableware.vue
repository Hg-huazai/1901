<template>

	<div id="tableware">
		<div class="tableware">
			<!--座位号-->
			<div class="seat-number">
				<h1>我的座位号：</h1>
				<input type="text" placeholder="请输入座位号" />
			</div>

			<ul class="seat-list-choose">
				<li class="pretty">	
					<label><i class="addimg"></i><input name="size" type="checkbox" value="" />碗</label>
				</li>
				<li class="pretty">		
					<label><i></i><input name="size" type="checkbox" value="" /> 筷子</label>
				</li>
				<li class="pretty">					
					<label><i></i><input name="size" type="checkbox" value="" />勺子</label>
				</li>
				<li class="pretty">				
					<label><i></i><input name="size" type="checkbox" value="" /> 牙签</label>
				</li>
				<li class="pretty">				
					<label><i></i><input name="size" type="checkbox" value="" /> 餐巾纸</label>
				</li>
			</ul>	
			<div class="button-true" @click="enter">确定</div>
		</div>
</div>
</template>

<script>
export default {
	name:"tableware",
	
	created(){
	 //触发actions里面叫做menushow这个方法
	  this.$store.dispatch('menushow',true)

 },

	methods:{
		enter(){
			this.$alert("餐厅服务暂无，敬请期待")
		}
	}
 

  
}
 
</script>
<style>
 	input{background-color:transparent; border-color:transparent;-webkit-appearance: none;}
	.pretty input{border:solid 1px #889260;width: .36rem;height: .36rem;margin-right:8px;}
	.tableware{
		top: 25%!important;
	}
	.button-true{
		bottom:20%;
	}

</style>

