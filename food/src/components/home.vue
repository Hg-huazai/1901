<template>
  <div>
    <!--header-->
		<header >
			<a href="scanCode.html" class="location" id="location" data-title-type="native">
				<img src="/static/img/sys.png" />
			</a>

			<div class="top-sch-box flex-col logoIcon">
				<a>
					<aside class="index-searchArea">
						<input class="input-text-searchArea" type="text" placeholder="请输入餐品" />
						<input type="button" value="&#63;" class="input-searchBtn" />
					</aside>
				</a>
			</div>
			<a class="rt_searchIcon" href="map.html"><img style="width:70%;" src="/static/img/mapIcon.png"></a>
		</header>
 
		<!--轮播图-->
		<div id="slide" class="public-banner">
      <el-carousel height="150px" :autoplay="true">
        <el-carousel-item v-for="(item,key) in top" :key="key">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <router-link to="/">
                <img :src="item.thumb" />
              </router-link>
            </div>
          </div>
        </el-carousel-item>
      </el-carousel>
			<div class="pagination"></div>
		</div>
      
    <!--今日促销-->	
    <div class="hot-container">
        <swiper :options="swiperOption" class="hotlist">
          <swiper-slide v-for="(item,key) in hot" :key="key" class="hot-item">
            <div>
              <div class="menu-img">
                <img :src="item.thumb" />
              </div>
              <div class="menu-txt hot-info">
                <h4>{{item.name}}</h4>
                <p class="list2">
                  <b>￥{{item.price}}<em>(6折)</em></b>
                  <div class="btn">  
                    <button class="minus" @click="minus(item.id)">-</button>
                    <i>{{item.count}}</i>  
                    <button class="add" @click="add(item.id)">+</button>
                  </div> 
                </p>
              </div>
            </div>
          </swiper-slide>
        </swiper>
    </div>
      
    <!--分类商品-->
    <el-tabs type="border-card" class="catelist" :tab-position="tabPosition" @tab-click="foodcate">
      <el-tab-pane :name="item.id" :key="key" :label="item.name" v-for="(item,key) in catelist" class="catefood">
          <div class="con">
            <div class="right-con con-active">
              <ul>
                <scroller class="scroller" :on-refresh="refresh" :on-infinite="infinite" ref="scrollerlist">
                  <li v-for="(item,key) in foodlist" :key="key" class="clearfix">
                    <div class="menu-img">
                      <img :src="item.thumb" width="55" height="55" />
                    </div>
                    <div class="menu-txt">
                      <h4>{{item.name}}</h4>
                      <h2>￥{{item.price}}</h2>
                      <p class="list2">	
                        <div class="btn">  
                          <button class="minus" @click="minus(item.id)">  
                            <strong>-</strong>  
                          </button>  
                          <i>{{item.count}}</i>  
                          <button class="add" @click="add(item.id)">  
                            <strong>+</strong>  
                          </button>
                        </div> 
                      </p>
                    </div>
                  </li>
                </scroller>
              </ul>
            </div>
          </div>
      </el-tab-pane>
    </el-tabs>

    <div class="footer">  
      <div class="left">
        <span id="cartN">
          <img src="/static/img/shop_03.png"/>
          <span id="totalcountshow">{{foodcount}}</span>
          <span class="totalpriceshow">￥<em id="totalpriceshow">{{foodprice}}</em></span>
        </span>				
        </div>  
      <div class="right">  
        <router-link id="btnselect" class="xhlbtn" to="/orderadd">
          去结算
        </router-link>
      </div>   
    </div>
  </div>
</template>

<script>
  let that
  export default {
    name:"home",
    beforeCreate()
    {
      that = this
    },
    created()
    {
      //获取产品分类
      this.$store.dispatch('catelist').then(res => {
        this.catelist = res.data.data
      })

      //触发actions里面叫做menushow这个方法
      this.$store.dispatch('menushow',true)


      //先获取当前用户的购物车数据
      this.$store.dispatch('cartdata',{userid:this.$cookies.get('user').id});
    },
    mounted()
    {
      //一进来请求获取食品数据
      this.$store.dispatch('hot')

      //获取所有商品
      this.$store.dispatch('foodlist')
    },
    data()
    {
      return {
        catelist:[],
        swiperOption:{
          slidesPerView:2,
          spaceBetween:20
        },
        tabPosition:"left",
        page:1,
        scrollIndex:0,
        cateid:0
      }
    },
    computed:{
      foodlist()//这是刚开始的映射
      {
        let foodlist = this.$store.state.food.foodlist//将查询出来的food.foodlist的数据给到foodlist
        for(var key in foodlist)
        {
          for(var cart of this.$store.state.food.cartdata)
          {
            if(cart.foodid == foodlist[key].id)//为了循环整个购物车表找出对应食物表的id,给他数量赋值
            {
              foodlist[key].count = cart.foodnum//这里的count数据库没有的，是上面foreach的时候添加的item.count
            }
          }
        }
        this.$store.state.food.foodlist = foodlist//将新的foodlist复制给food.foodlist
        return this.$store.state.food.foodlist
      },
      hot()//与上面的foodlist同理
      {
        let hot = this.$store.state.food.hot
        for(var key in hot)
        {
          for(var cart of this.$store.state.food.cartdata)
          {
            if(cart.foodid == hot[key].id)
            {
              hot[key].count = cart.foodnum
            }
          }
        }
        this.$store.state.food.hot = hot
        return this.$store.state.food.hot
      },
      top()
      {
        return this.$store.state.food.top
      },
      foodcount()
      {
        return this.$store.state.food.foodcount
      },
      foodprice()
      {
        return this.$store.state.food.foodprice
      },
    },
    methods:{
      foodcate(tab, event)
      {
        this.scrollIndex = tab.index
        this.cateid = tab.name
        this.refresh()
      },
      infinite()
      {
        this.load()
      },
      refresh()
      {
        this.$store.state.food.foodlist = [];
        this.page = 1
        this.load()
        //停止下拉刷新
        this.$refs.scrollerlist[this.scrollIndex].finishPullToRefresh()
      },
      load()
      {
        this.$store.dispatch('loadlist',{cateid:this.cateid,page:this.page})
        this.page += 1
        //停止上拉加载
        this.$refs.scrollerlist[this.scrollIndex].finishInfinite(true)
      },
      minus(foodid)
      {
        //减少
        let current = 0;
        let foodnum = 0;

        this.foodlist.forEach(item => {
          if(item.id == foodid)
          {
            if(item.count > 0)
            {
              item.count--
              current = foodid
              foodnum = item.count//购物车食品数量
            }else{
              this.$alert("无法继续减少")
            }
            
          }
        })

        this.hot.forEach(item => {
          if(item.id == foodid)
          {
            if(item.count > 0)
            {
              item.count--
              current = foodid
              foodnum = item.count
            }
          }
        })

        if(current)
        {
          this.$store.dispatch('cartedit',{foodid:current,foodnum:foodnum,userid:this.$cookies.get('user').id}).then(res => {
            //更新购物车数据
            this.$store.dispatch('cartdata',{userid:this.$cookies.get('user').id});
          })
        }


      },
      add(foodid)
      {
        let current = 0;
        let foodnum = 0;
        //增加
        this.foodlist.forEach(item => {
          if(item.id == foodid)
          {
            item.count++
            current = foodid
            foodnum = item.count
          }
        })

        this.hot.forEach(item => {
          if(item.id == foodid)
          {
            item.count++
            current = foodid
            foodnum = item.count
          }
        })

        if(current)
        {
          this.$store.dispatch('cartedit',{foodid:current,foodnum:foodnum,userid:this.$cookies.get('user').id}).then(res => {
            //更新购物车数据
            this.$store.dispatch('cartdata',{userid:this.$cookies.get('user').id});
          })
        }

        
      }
      
    }
  }
</script>


<style>
  /* .hot-item{
    width:48%!important;
    margin-right:20px;
  } */

  .menu-img{
    width:100%;
    height:150px;
  }

  .menu-img img{
    width:100%;
    height:100%;
  }
  .hot-container{
    background:#fff;
    padding:10px;
  }
  .hot-info h4{
    text-align:left;
    text-indent: 20px;
  }

  .btn{
    background-color: transparent;
    position: absolute;
    right: 1%;
    top: 86%;
    cursor: pointer;
  }

  .btn button{
    background-color: #26C400;
    color: #fff;
    font-size: .3rem;
    width: 0.459rem;
    height: 0.459rem;
    border-radius: .5rem;
  }

  .btn button.minus
  {
    display: inline-block!important;
  }

  .con .right-con li .btn i
  {
    display: inline-block!important;
  }

  .catelist{
    overflow: visible!important;
  }

  .catefood{
    padding:0!important;
  }

  .con .right-con{
    width:100%!important;
    overflow-y: visible!important;
  }

  .el-tabs__content{
    padding:0px!important;
    padding-top:15px;
  }

  .con .right-con ul::after{
    content:"";
    display: block;
    width:0;
    height:0;
    overflow: hidden;
    clear: both;
  }

  .scroller li:last-of-type{
    padding-bottom:20px!important;
  }

  .loading-layer{
    margin-bottom:100px;
  }
</style>