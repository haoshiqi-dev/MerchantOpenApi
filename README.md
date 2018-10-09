好食期商户开放接口
===========================
这是好食期商户开放接口的开发文档，提供了授权给商户的开放接口的使用方法和说明。

## 目录
* [签名方式](#签名方式)
* [获取商户未发货订单列表](#获取商户未发货订单列表)
* [获取商户某个订单信息](#获取商户某个订单信息)
* [推送物流信息](#推送物流信息)
* [获取商户的所有订单](#获取商户的所有订单)
* [获取商户的所有sku](#获取商户的所有sku)
* [更新sku库存](#更新sku库存)
* [sku单品详情](#sku单品详情)

***

### 签名方式
参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796 接口请求的时间，格式为时间戳格式
appId | 必填 | text | APP ID | test
privateKey | 必填 | text | 私钥 | test

appId和privateKey是统一下发的，并且唯一。

**1、签名算法**  
签名生成的通用步骤如下：   
`第一步`，设发送的参数为集合M，将集合M内非空参数值的参数按照参数名ASCII码从小到大排序（字典序），使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串stringA。  
`加密参数有且仅有3个字段appId、privateKey、timeStamp构成。`    
特别注意以下重要规则：  
◆ 参数名ASCII码从小到大排序（字典序）；  
◆ 参数名区分大小写；  
◆ 验证调用签名时，传送的sign参数不参与签名，将生成的签名与该sign值作校验。   
`第二步`，在stringA最后拼接上privateKey得到stringSignTemp字符串，并对stringSignTemp进行MD5运算，再将得到的字符串所有字符转换为大写，得到sign值signValue。  

**2、签名举例**  
假设传送的参数如下：  

appId：M_101  
timeStamp：1570825151  
`第一步`：对参数按照key=value的格式，并按照参数名ASCII字典序排序如下：  
stringA="appid=M_101&timeStamp=1570825151";  
`第二步`：拼接API密钥：  

stringSignTemp="stringA&privateKey=test"  
`sign`=MD5(stringSignTemp).toUpperCase()="9A0A8659F005D6984697E2CA0A9CF3B7"  
最终得到签名  `(/src/index.php有PHP版本的签名算法)`

**3、返回格式**

```
{
	"errno":0, // 非0为业务处理失败
	"errmsg":"success", //当失败时候，这里是失败原因的简短描述
	"data":{ //业务数据
		"res":true
	},
	"timestamp":1539048644,
	"serverlogid":"41858d7c78cb9a5f4e3a0a2efa9379e2"
}
```

***

### 获取商户未发货订单列表
**接口地址 : /merchantapi/waitdeliveryorderlist**

**请求方法 :`GET`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
pageLimit | 选填 | int | 分页显示数量 | 默认为10，最大100
pageNum | 选填 | int | 分页页码 | 默认为1
paginationType | 选填 | int | 分页方式 | 不填默认为 1:顺序分页 2:nextId分页 
nextId | 选填 | int | 获取的最近一个订单ID，不传默认为0 | 

**返回数据**

参数名 | 必填  | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
id | 必填 | int | 订单ID |  |
user_id | 必填 | int | 用户ID |  |
user_name | 必填 | text | 用户昵称 |   |
merchant_id | 必填 | int | 商户ID |  |
market_price | 必填 | int | 订单市场价 |  |
total_price | 必填 | int | 总价 |  |
pay_price | 必填 | int | 支付金额 |  |
delivery_price | 必填 | int | 运费 |  |
status | 必填 | int | 订单状态 | 订单状态 1.未支付 2.已支付.3.已完成 4.已取消 5. 申请退款 6.退款中 7.  已退款  8.拒绝退款   |
delivery_status | 必填 | int | 配送状态 | 配送状态：1.未发货 2.已发货  3.配送完成 |
merchant_discount | 必填 | int | 商家折扣 |   |
platform_discount | 必填 | int | 平台折扣 |  |
discount_price | 必填 | int | 优惠金额 |  |
total_amount | 必填 | int | 总数量 |  |
delivery_type | 必填 | int | 配送类型 |  配送类型:1. 无时间限制 2.工作日配送 3.仅周末配送|
note | 选填 | text | 备注 |  |
delivery_province | 必填 | text | 配送省份 |  |
invoice_type | 选填 | int | 发票类型 | 发票类型 1.不需要发票  2.个人发票 3.公司发票 |
invoice_title | 选填 | int | 发票抬头 |  |
delivery_city | 必填 | text | 配送城市 |  |
delivery_district | 必填 | text | 配送区县 |  |
delivery_detail_address | 必填 | text | 配送具体地址 |  |
consignee | 必填 | text | 收货人 |  |
consignee_phone | 必填 | text | 收货人电话 |  |
created_at | 必填 | int | 下单时间 |  |
sku_list | 必填 | array | 子订单详情 |

**sku_list**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
id | 必填 | int | 子订单ID |  |
product_id | 必填 | int | 商品id |  |
sku_id | 必填 | int | 单品id |  |
sku_name | 必填 | text | 单品名称 |  |
sku_thumbnail | 必填 | text | 单品缩略图 |  |
unit_price | 必填 | int | 单价 |  |
market_price | 必填 | int | 市场价 |  | 
amount | 必填 | int | 数量 |   |
total_price | 必填 | int | 总价 | |
discount_price | 必填 | int | 商家折扣 |  优惠金额 |
pay_price | 必填 | int | 平台折扣 | 支付金额 |
status | 必填 | int | 单品订单状态 | 1.未支付 2.已支付.3.已完成 4.已取消 5. 申请退款 6.退款中 7.  已退款  8.拒绝退款
is_free | 选填 | text | 是否是赠品 |  |
created_at | 必填 | int | 下单时间 |  |
merchant_discount | 必填 | int | 商家折扣 |   |
platform_discount | 必填 | int | 平台折扣 |  |
merchant_item_code | 必填 | text | 商家编码 |   |

***

### 获取商户某个订单信息
**接口地址 : /merchantapi/orderinfo**

**请求方法 :`GET`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
orderId | 必填 | int | 订单ID | 2147565312

 **返回数据**

参数名 | 必填  | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
id | 必填 | int | 订单ID |  |
user_id | 必填 | int | 用户ID |  |
user_name | 必填 | text | 用户昵称 |   |
merchant_id | 必填 | int | 商户ID |  |
market_price | 必填 | int | 订单市场价 |  |
total_price | 必填 | int | 总价 |  |
pay_price | 必填 | int | 支付金额 |  |
pay_time | 必填 | int | 支付时间 | |
delivery_price | 必填 | int | 运费 |  |
status | 必填 | int | 订单状态 | 订单状态 1.未支付 2.已支付.3.已完成 4.已取消 5. 申请退款 6.退款中 7.  已退款  8.拒绝退款   |
delivery_status | 必填 | int | 配送状态 | 配送状态：1.未发货 2.已发货  3.配送完成 |
merchant_discount | 必填 | int | 商家折扣 |   |
platform_discount | 必填 | int | 平台折扣 |  |
discount_price | 必填 | int | 优惠金额 |  |
total_amount | 必填 | int | 总数量 |  |
delivery_type | 必填 | int | 配送类型 |  配送类型:1. 无时间限制 2.工作日配送 3.仅周末配送|
note | 选填 | text | 备注 |  |
delivery_province | 必填 | text | 配送省份 |  |
invoice_type | 选填 | int | 发票类型 | 发票类型 1.不需要发票  2.个人发票 3.公司发票 |
invoice_title | 选填 | int | 发票抬头 |  |
delivery_city | 必填 | text | 配送城市 |  |
delivery_district | 必填 | text | 配送区县 |  |
delivery_detail_address | 必填 | text | 配送具体地址 |  |
consignee | 必填 | text | 收货人 |  |
consignee_phone | 必填 | text | 收货人电话 |  |
created_at | 必填 | int | 下单时间 |  |
sku_list | 必填 | array | 子订单详情 |

**sku_list**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
id | 必填 | int | 子订单ID |  |
product_id | 必填 | int | 商品id |  |
sku_id | 必填 | int | 单品id |  |
sku_name | 必填 | text | 单品名称 |  |
sku_thumbnail | 必填 | text | 单品缩略图 |  |
unit_price | 必填 | int | 单价 |  |
market_price | 必填 | int | 市场价 |  |
amount | 必填 | int | 数量 |   |
total_price | 必填 | int | 总价 | |
discount_price | 必填 | int | 商家折扣 |  优惠金额 |
pay_price | 必填 | int | 平台折扣 | 支付金额 |
status | 必填 | int | 单品订单状态 | 1.未支付 2.已支付.3.已完成 4.已取消 5. 申请退款 6.退款中 7.  已退款  8.拒绝退款
is_free | 选填 | text | 是否是赠品 |  |
created_at | 必填 | int | 下单时间 |  |
merchant_discount | 必填 | int | 商家折扣 |   |
platform_discount | 必填 | int | 平台折扣 |  |
merchant_item_code | 必填 | text | 商家编码 |   |

***

### 推送物流信息
**接口地址 : /merchantapi/pushdeliverymsg**

**请求方法 :`POST`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
param | 必填 | json | 物流信息列表 | 支持多个，详细请看"param字段参数"

**param字段参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
orderId | 必填 | int | 平台订单编号 | 2147483649
deliveryComCode | 必填 | text | 物流公司编码 | huitongkuaidi
deliveryNo | 必填 |text | 物流单号 | 2147483649214
type | 选填 | int | 推送类型 0(默认):添加物流单号 1:重置物流单号 | 0

**param字段值sample**

`*单次推送最多支持20条物流信息`
<pre>
[{"orderId":"2147483649","deliveryComCode":"yuantong","deliveryNo":"710291798405","type":0},{"orderId":"2147483659","deliveryComCode":"huitongkuaidi","deliveryNo":"211033681228","type":1}]
</pre>

**返回数据**

参数名 | 必填  | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
success | 必填 | int | 推送成功的数量 |  |
failed | 必填 | int | 推送失败的数量 |  |
failed_note | 选填 | array | 推送失败的原因 |   |

*物流公司标准名称*

物流公司编码 | 物流单号
------------ | ------------
huitongkuaidi | 百世汇通	
yuantong | 圆通速递	
shentong | 申通快递	
zhongtong | 中通快递	
shunfeng | 顺丰速运	
yunda | 韵达快递	
tiantian | 天天快递	
youzhengguonei | 中国邮政	
quanfengkuaidi | 全峰快递	
zhaijisong | 宅急送	
ems | EMS	
kuaijiesudi | 快捷速递	
youshuwuliu | 优速物流	
guotongkuaidi | 国通快递	
zhaijibian | 宅急便	
suer | 速尔快递	
debangwuliu | 德邦物流	
yuanchengwuliu | 远成物流	
jd | 京东	
annengwuliu | 安能物流	
yxexpress | 亿翔	
baishiwuliu | 百世物流
wanxiangwuliu | 万象物流

***

### 获取商户的所有订单
**接口地址 : /merchantapi/orderlist**

**请求方法 :`GET`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
pageLimit | 选填 | int | 分页显示数量 | 默认为10，最大100
pageNum | 选填 | int | 分页页码 | 默认为1
paidTime | 选填 | string | 订单支付时间 | 开始时间,结束时间(1519723173,1519723180)，默认全部订单

**返回数据**

同 `获取商户未发货订单列表` 接口

***

### 获取商户的所有sku
**接口地址 : /merchantapi/merchantskulist**

**请求方法 :`GET`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
pageLimit | 选填 | int | 分页显示数量 | 默认为10，最大100
pageNum | 选填 | int | 分页页码 | 默认为1

**返回数据**

参数名 | 必填  | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
id | 必填 | int | 好食期平台的SKU ID |  |
merchant_item_code | 必填 | string | 商家编码 |  |
name | 必填 | string | Sku名称 |   |
merchant_id | 必填 | int | 商家ID |   |
product_id | 必填 | int | 产品ID |   |
left_stock | 必填 | int | 剩余库存 |   |
attrs | 必填 | array | 商品属性 |   |

*attrs字段值*

参数名 | 必填  | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
name | 必填 | string | 属性名称 | 规格
value | 必填 | string | 属性值 | 125ml

***

### 更新sku库存
**接口地址：/merchantapi/updateskustock**
**请求方法 :`POST`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
merchantItemCode | 必填 | string | 商家编码 | xxxx
type | 必填 | int | 增加或者减少库存 | 1: 增加，2：减少
stockCnt | 必填 | int | 修改的库存的绝对值 | 10

***
### sku单品详情
**接口地址：/merchantapi/merchantskuinfo**
**请求方法 :`GET`**

**请求参数**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
timeStamp | 必填 | int | 时间戳 | 1478589796
appId | 必填 | text | APP ID | test
sign | 必填 | text | 签名 | E5F7D96195B17794857A88B6952F5169
merchantItemCode | 必填 | string | 商家编码 | xxxx

**返回数据**

参数名 | 必填 | 类型 | 描述 | 样例
------------ | ------------ | ------------ | ------------ | ------------
id | 必填 | int | 好事情sku id | 1478589796
merchant_item_code | 必填 | string | 商家编码 | test
name | 必填 | string | 商品名称 | HERSHEY'S好时巧克力原装整袋1.1kg牛奶巧克力口味婚庆喜糖
merchant_id | 必填 | int | 商家ID | xxxx
product_id | 必填 | int | 商品ID | 12121
attrs | 必填 | array | 属性列表 | {"name":"批次","value":"20181025"}
left_stock | 必填 | int | 剩余库存 | 121