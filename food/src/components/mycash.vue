<template>
<el-container>
    <el-main class="main">
		<ul class="formarea mobile-phone">
			<li style="line-height:60px">
				<i class="el-icon-s-custom"></i>充值方式：
			</li>
			<li>
				<!-- <label class="lit">充值方式：</label> -->
				<el-select v-model="value" placeholder="请选择" @change="changepay(value)">
					<el-option
					v-for="item in options"
					:key="item.value"
					:label="item.label"
					:value="item.value">
					</el-option>
				</el-select>
			</li>
		
			<li>
				<label class="lit">充值金额：</label>
				<input type="number" v-model="cash" placeholder="请输入金额" class="textbox" />
				<button class="yanzhegma"  @click="locationenter()">充值</button>
			</li>
				<li>
				<label class="lit">余额：</label>
				<input type="number" v-model="cashdata" class="textbox" disabled/>
			</li>
		</ul>
		</el-main>
		<!-- <el-footer class="addrfooter">
			<el-row>
			<el-button type="success"    @click.prevent="locationenter()">绑定</el-button>
			</el-row>
		</el-footer> -->
	</el-container>
</template>

<script>
export default {
	name:"mycash",
	inject: ['reload'],
	created(){
	 //触发actions里面叫做menushow这个方法
	  this.$store.dispatch('menushow',true)
	  
	   this.$store.dispatch('cashdata',{userid:this.$cookies.get('user').id}).then(res => {
		   this.cashdata=res.data.data.money
	   })
 },
  methods:{
      locationenter()
      {
		// this.userdata.id= this.$cookies.get('user').id
        this.$store.dispatch('mycash',{userid:this.$cookies.get('user').id,value:this.value,money:this.cash}).then(res => {
          if(res.data.result)
          {
            this.$alert(res.data.msg).then(result => {
              this.reload()
            })
          }else{
            this.$alert(res.data.msg)
          }
        })
	  },
	  changepay(value){
		  console.log(this.value);
	  }
  },
  data() {
      return {
        options: [{
          value: '支付宝',
          label: '支付宝'
        }, {
          value: '微信',
          label: '微信'
        }, {
          value: '浦发银行',
          label: '浦发银行'
        }, {
          value: '农业银行',
          label: '农业银行'
        }, {
          value: '招商银行',
          label: '招商银行'
        }],
		value: '',
		cashdata:0,
		cash:0,
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

