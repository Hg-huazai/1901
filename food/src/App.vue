<template>
  <div id="app">
    <router-view v-if="isRouterAlive"></router-view>
    <menulist></menulist>
  </div>
</template>

<script>

//引入组件模板
import menulist from './components/menulist'
export default {
  name: 'App',
  components:{
    menulist
  },
   provide () {
    return {
      reload: this.reload
    }
  },
  data () {
    return {
      isRouterAlive: true
    }
  },
  methods: {
    reload () {
      this.isRouterAlive = false
      this.$nextTick(function() {
         this.isRouterAlive = true
      })
    }
  }
}
</script>