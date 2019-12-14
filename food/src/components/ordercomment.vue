<template>
<el-container>
    <el-main class="main">
		<ul class="formarea">
			<li>
				<label class="lit">订单评价</label>	
			</li>	
			<li>
				<el-rate v-model="value" show-text @change="add(value)"></el-rate>
			</li>
			<li>
				<label class="lit">评论内容</label>
				<input type="text" v-model="userdata.content" placeholder="请输入您的评价内容" class="textbox" />
			</li>
	
		</ul>
		
		</el-main>
		<el-footer class="addrfooter">
			<el-row>
			<el-button type="primary" round @click.prevent="addcomment()">确认</el-button>
			</el-row>
		</el-footer>
	</el-container>
</template>

<script>
export default {
	name:"ordercomment",
	created(){
	 //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)
 },
  data(){
	  return{
		   value:null,
		// userdata:[],
	   userdata:{
		   orderid:this.$route.query.orderid,
		   content:"",
		   userid:this.$cookies.get('user').id,
		   level:this.value,
		   createtime:"",
         }
	 }
  },
  methods:{
      addcomment()
      {
		// this.userdata.id= this.$cookies.get('user').id
        this.$store.dispatch('ordercomment',this.userdata).then(res => {
          if(res.data.result)
          {
            this.$alert(res.data.msg).then(result => {
              this.$router.push('/orderlist')
            })
          }else{
            this.$alert(res.data.msg)
          }
        })
	  },
	  add(ond){ 
		  this.userdata.level=this.value;
		  console.log(this.value);
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

