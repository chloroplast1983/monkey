# monkey
---

## 版本

* 1.0

## 目录

* [简介](#abstract) 
* [安装](#install)
* [how-to-start](#how-to-start)

## <a name="abstract">简介</a>

该框架主要是用于实现以调用接口为目的的前端框架. 核心思想还是基于[marmot](https://github.com/chloroplast1983/marmot)框架的思路, 主要实现如下功能:

1. 并行请求接口.
2. 接口封装
	* 超时
	* 压缩
	* 日志链的`REQUEST_ID`(配合后端框架使用).
3. 缓存实现, 以及在分布式场景下基于`rabbitmq`通过事件驱动对缓存更新.
4. 统一错误输出,使用`lastError`
5. 在上层实现`csrf`检测功能
6. 基于`smarty`框架实现插件:
	* `csrf`输出`token`值.
	* `csrf_field`输出`input`隐藏域并填入`csrf`的`token`值.
	* 实现`widget`组件的概念.
	* 在模板实现`encode`加密输出, 使用内置扩展函数`marmot_encde`.
	* `marmot_mask`实现掩码

## <a name="install">安装</a>

## <a name="how-to-start">How to start</a>

