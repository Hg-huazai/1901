<template>
  <div>
    <!--banner-->
		<div id="slide" class="public-banner" style="margin-top: 0;">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<a href="service.html#">
						<img src="/static/upload/banner1.jpg.png" />
					</a>
				</div>
				<div class="swiper-slide">
					<a href="service.html#">
						<img src="/static/upload/banner2.jpg" />
					</a>
				</div>
			</div>
			<div class="pagination"></div>
		</div>

		<ul class="serviceList clearfix">
			<li>
				<router-link to="/checkwifi" >
					<img src="/static/img/fuwu (1).png" />
					<p>查WIFI</p>
				</router-link>				
			</li>
			<li>
				<router-link to="/tableware" >
					<img src="/static/img/fuwu (2).png" />
					<p>要餐具</p>
				</router-link>					
			</li>
			<li>
			<router-link to="/zuowei" >
					<img src="/static/img/fuwu (3).png" />
					<p>找位子</p>
				</router-link>
				
			</li>			
		</ul>
		
		<ul class="serviceList clearfix" style="margin: 0;">			
			<li>
					<router-link to="/waiter" >
					<img src="/static/img/fuwu (4).png" />
					<p>服务员</p>
					</router-link>				
			</li>
			<li>
				<router-link to="/invoice" >
					<img src="/static/img/fuwu (5).png" />
					<p>发票</p>
				</router-link>					
			</li>
			<li>
				<router-link to="/" >
					<img src="/static/img/fuwu (6).png" />
					<p>打包</p>
				</router-link>					
			</li>
		</ul>
  </div>
</template>


<script>
  export default {
    name:"service"
  }
</script>