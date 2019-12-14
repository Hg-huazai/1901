<template>

   <div class="wifiCon" @click="enter">
			<img src="/static/img/zuowei_02.png" />
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
			this.$alert("本未开业，敬请期待")
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
</style>

