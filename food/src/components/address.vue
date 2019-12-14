<template>
  <el-container>
      <el-main>
        <el-row>
          <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
            <div class="addr">
              <label class="lit">选择省</label>
              <el-select v-model="address.province" placeholder="请选择" class="address" @change="changeCity()">
                <el-option
                  v-for="item in provinces"
                  :key="item.region_id"
                  :label="item.region_name"
                  :value="item.region_id"
                  >
                </el-option>
              </el-select>
            </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
            <div class="addr">
              <label class="lit">选择市</label>
              <el-select v-model="address.city" placeholder="请选择" class="address" @change="changeArea()">
                <el-option
                  v-for="item in city"
                  :key="item.region_id"
                  :label="item.region_name"
                  :value="item.region_id"
                  >
                </el-option>
              </el-select>
            </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
            <div class="addr">
              <label class="lit">选择区</label>
              <el-select v-model="address.area" placeholder="请选择" class="address" @change="selectArea()">
                <el-option
                  v-for="item in area"
                  :key="item.region_id"
                  :label="item.region_name"
                  :value="item.region_id"
                  >
                </el-option>
              </el-select>
            </div>
          </el-col>
        </el-row>
      </el-main>
  </el-container>
</template>


<script>
  export default {
    name:"addr",
    created(){
      this.$store.dispatch('province').then(res => {
        this.provinces = res.data.data
      })
    },
    data()
    {
      return {
        address:{
          city:"",
          area:""
        },
        provinces:[],
        city:[],
        area:[]
      }
    },
    methods:{
      changeCity()
      {
        this.city = [];
        this.area = [];
        this.address.city = "";
        this.address.area = "";
        //选择省 切换市
        this.$store.dispatch('city',{provinceid:this.address.province}).then(res => {
          this.city = res.data.data
        })

        this.$emit('change',this.address)
      },
      changeArea()
      {
        this.area = [];
        this.address.area = "";
        //选择市 切换区域
        this.$store.dispatch('area',{cityid:this.address.city}).then(res => {
          this.area = res.data.data
        })

        this.$emit('change',this.address)
      },
      selectArea()
      {
        this.$emit('change',this.address)
      }
    }
  }
</script>

<style>
  .addr{
    position: relative;
  }
  .address{
    width: 75%;
    padding: .1rem 6%;
    border: none;
    margin-left: 1.5rem;
    display: inline-block;
  }

  label{
    position: absolute;
    left: 3%;
    top: 0;
    line-height: .94rem;
  }
</style>