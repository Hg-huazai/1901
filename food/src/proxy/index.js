import userProxy from './user'
import cityProxy from './city'
import addressProxy from './address'
import foodProxy from './food'
import addreditProxy from './addredit'
import usertextProxy from './usertext'
import orderProxy from './order'

//index.js的作用就是将封装为多个的请求模块最终合并到一起
export default {
  ...userProxy,
  ...cityProxy,
  ...addressProxy,
  ...foodProxy,
  ...orderProxy,
  ...addreditProxy,
  ...usertextProxy
}