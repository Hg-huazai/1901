<template>
<el-container>
    <el-main class="main">
			  <el-tooltip class="item" effect="dark" content="Top Center 提示文字" placement="top" transition="el-fade-in-linear">
					<el-button>请修改你的头像</el-button>
				</el-tooltip>
		
				<form action='http://localhost:8080/api/usertext.php?action=jiege' target="iframe" method="post" enctype="multipart/form-data">
					<input  type="file" name="file" id="file" @change="sub">
					<iframe id="frame" name="iframe" style="display:none;"></iframe>
					
						
						<input id="input" type="submit" name="submit" value="提交"  @click="skt">
					
				</form>
		
		</el-main>
		
	</el-container>
</template>

<script>
export default {
	name:"useravatar",
	created(){
	 //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)
 },
  methods:{
	  sub(e){
		 if(e.target.files[0]!=""){
			    this.file = e.target.files[0];
		this.avatar="/upload/"+this.file.name;
		 }	
	  },
	  skt(){
		 if(this.file!=""){
			  this.$store.dispatch('myavatar',{avatar:this.avatar,userid:this.$cookies.get('user').id}).then(res=>{
			if(res.data.result)
          	{
            this.$alert(res.data.msg).then(result => {
              this.$router.push('/user')
            })
          }else{
            this.$alert(res.data.msg)
          }
		  })
		 }else{
			 this.$alert("未修改头像").then(result => {
              this.$router.push('/user')
            })
		 }
	  }
  },
  data(){
	  return{
		 avatar:"", 
		 file:"",
	  }
  }

  
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
  #input{
	  position: fixed;
	  z-index: 888;
	  left: 50%;
	  top: 20%;
	  transform: translate(-50%,-50%);
	  width: 100px;
	  height: 50px;
	  background-color: green;
	  border-radius: 10px;
	  color: #fff;
	  line-height: 50px;
	  font-size: 20px;
  }
  #file{
	  width: 300px;
	  height: 80px;
  }
</style>

