<template>
<el-container>
    <el-main class="main">
		<ul class="formarea">
			<li>
				<label class="lit">姓名</label>
				<input type="text" v-model="userdata.username" placeholder="请输入您的姓名" class="textbox" />
			</li>
			<li>
				<label class="lit">性别</label>
				<div class="choose">
					<label><input name="gender" type="radio" value="0" v-model="userdata.sex"/>先生 </label>
					<label><input name="gender" type="radio" value="1" v-model="userdata.sex"/>女士 </label>
				</div>
			</li>
			<li>
				<label class="lit">身份证号</label>
				<input type="number" v-model="userdata.identity" placeholder="请输入您的身份证号" class="textbox" />
			</li>
			<li>
				<label class="lit">职业</label>
				<input type="text" v-model="userdata.job" placeholder="请输入您的职业" class="textbox" />
			</li>
			<li>
				<label class="lit">岗位</label>
				<input type="text"  v-model="userdata.position" placeholder="请输入您的岗位" class="textbox" />
			</li>
			<li class="clearfix">
				<label class="lit">月收入水平</label>
				<div class="choose">
					<label><input name="mouth" type="radio" value="1"  v-model="userdata.income"/>0~3K </label>
					<label><input name="mouth" type="radio" value="2"  v-model="userdata.income"/>3~6K </label>
					<label><input name="mouth" type="radio" value="3"  v-model="userdata.income"/>6K+ </label>
				</div>
			</li>
			<!-- <li>
				<label class="lit">请上传头像</label>
			</li>
			<li>		
				 <input type="file" name="image" accept="image/*" @change='onchangeImgFun' />
			</li> -->
		</ul>
		<!-- <div style="height:1.2rem;"></div> -->
		<!-- <div class="button-order-det">确认</div> -->
		</el-main>
		<el-footer class="addrfooter">
			<el-row>
			<el-button type="primary" round @click.prevent="locationEdit()">确认</el-button>
			</el-row>
		</el-footer>
	</el-container>
</template>

<script>
export default {
	name:"usertext",
	created(){
	 //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)

	  this.ressid= this.$cookies.get('user').id
	//   console.log(this.ressid)

      // 一进来给他数据
     this.$store.dispatch('usertext',{ressid:this.ressid}).then(res => {
		 if(res.data.data){
		this.userdata=res.data.data       
        // console.log(this.userdata)
		 }

      })
 },
  methods:{
      locationEdit()
      {
		this.userdata.id= this.$cookies.get('user').id
        this.$store.dispatch('mytext',this.userdata).then(res => {
          if(res.data.result)
          {
            this.$alert(res.data.msg).then(result => {
              this.$router.push('/user')
            })
          }else{
            this.$alert(res.data.msg)
          }
        })
	  },
	//   onchangeImgFun (e) {
	// 	 var file = e.target.files[0];
		// this.userdata.avatar="/static/img/"+file.name;
		//  console.log(this.userdata.avatar);
		 // this.imgStr = window.URL.createObjectURL(e.target.files[0])
        // console.log(window.URL.createObjectURL(e.target.files[0])) // 获取当前文件的信息
	//   }
	 
  },
  data(){
	  return{
		userdata:[],
		ressid:0,
	   userdata:{
		   username:"",
		   id:"",
		   phone:"",
		   money:"",
		   sex:"",
			job:"",
			identity:"",
			position:"",
			job:"",
			income:"",
			avatar:"",
         }
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

	
</style>


