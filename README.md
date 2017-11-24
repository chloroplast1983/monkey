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

我们基于`CQRS`角度来考虑问题.

### 查询数据操作

#### mock数据开发

为了解耦前端人员挂接页面, 我们需要事先输出数据. 方便前端开发人员在实现`ajax`时, 可以方便模拟. 开发步骤如下:

1. 在代码设计图里面实现应用服务层
	* 路由, 参考`restful`路由设计思路, 保证路由设计的可读性.
	* 输入数据
	* 输出数据
2. 实现`Model`,`View`和`Controller`应用服务层
3. 实现`控件规范`和`错误规范`

#### 实现思路

假设我们需要实现:

* 用户详情接口(ajax)
* 用户列表接口(ajax)
* 用户列表页面, 输出模板.

#### 设计路由

在`Controller`文件夹内.

* 用户列表页面输出
	* 方法`GET`
	* 路由`users/index`
* 用户列表数据输出`json`
	* 方法`GET `
	* 路由`users`
* 用户详情接口输出`json`
	* 方法`GET`
	* 路由`users/{id:\d+}`

如果一个路由`users/signUp`表示添加用户.

* `GET`输出模板页面.
* `POST`添加注册.

这样一个路由可以同时输出页面, 也可以表示添加数据. 这里在**修改数据操作**模块内继续详细描述.

#### mock数据: 构建模型

根据需求构建模型. 在`Model`文件夹内.

#### mock数据: 构建翻译器

这里需要创建一个默认翻译器. 类似如果我的模型是`User`. 则创建一个`UserTranslator`翻译器. 用于翻译从模型到`ajax`输出的`json`数据.

注意如果你的模型是这样一个包含关系.

```php
class User
{
	private $userGroup;//UserGroup 对象
	
	public function getUserGroup() : UserGroup
}
```

用户`user`对象包含了`userGroup`对象.

这里就需要在`UserTranslator`翻译器中,调用`UserGroupTranlator`翻译器.返回`userGroup`数据.


```php
array(
	'id'=>数字id, //UserTranslator
	'name'=>用户名字, //UserTranslator
	'userGroup`=>array(
		'id'=>用户组id,	//UserGroupTranlator
		'name'=>用户组名	//UserGroupTranlator
	)
)
```

#### mock数据: 生成view产出json-mock数据

在`View/Json`文件夹内生成`UserListView.class.php`.

```php
<?php
namespace Member\View\Json;

use System\View\JsonView;
use System\Interfaces\IView;
use Member\Translator\UserTranslator;

class UserListView extends JsonView implements IView
{
    private $users;
    
    private $translator;
    
    public function __construct(array $users = array())
    {
        $this->users = $users;
        $this->translator = new UserTranslator();
        parent::__construct();
    }
    
    protected function getUsers() : array
    {
        return $this->users;
    }
    
    protected function getTranslator() : UserTranslator
    {
        return $this->translator;
    }
    
    public function render() : void
    {
        $data = array();
        foreach ($this->getUsers() as $user) {
            $data[] = $this->getTranslator()->objectToArray($user);
        }
        $this->encode($data);
    }
}
```

* 继承`JsonView`
* 实现`IView`
* 把对象翻译成数组
* 通过`render()`函数渲染, 这里调用`$this->encode(数组);`, 会直接输出`json`数据.

#### mock数据: 生成view产出模板

在`View/Template`文件夹内生成`SignUpView.class.php`.

```php
<?php
namespace Member\View\Template;

use System\View\TemplateView;
use System\Interfaces\IView;

class SignUpView extends TemplateView implements IView
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function render() : void
    {
        $this->getView()->display('User/SignUp.tpl');
    }
}
```

* 如果自己要接收传参, 必须在自己的构造函数内, 调用父类的`__construct`.
* `render()`调用`$this->getView()->display('User/SignUp.tpl');`渲染`smarty`模板.
* 如果需要`assign`变量或者赋值模板, 需要在构造函数内传输数据, 在`render`内赋值变量, 渲染到模板.

#### mock数据: 创建mock对象

`tests/UnitTest/Application/Member/Utils/`创建文件`ObjectGenerate.php`.

使用`Faker`创建随机数据, 生成对象.

```php
<?php
namespace Member\Utils;

use Member\Model\User;

class ObjectGenerate
{
    public static function generateUser(
    int $id = 0,
    int $seed = 0,
    array $value = array()
    ) : User {
    
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);//设置seed,放置和生成数据相同
        
        $user = new User($id);
        
        //cellphone
        $cellphone = isset($value['cellphone']) ? $value['cellphone'] : $faker->phoneNumber;
        $user->setCellphone($cellphone);
        
        //password,salt
        $password = isset($value['password']) ? $value['password'] : $faker->password;
        $salt = isset($value['salt']) ? $value['salt'] : $faker->bothify('##??');
        $user->encryptPassword($password, $salt);
        $user->setCreateTime($faker->unixTime());
        $user->setUpdateTime($faker->unixTime());
        $user->setStatusTime($faker->unixTime());
        
        //status
        $status = isset($value['status']) ? $value['status'] : $faker->randomElement(
            $array = array(
                            User::STATUS_NORMAL,
                            User::STATUS_DELETE
                        )
        );
        $user->setStatus($status);
        
        //nickName
        $nickName = isset($value['nickName']) ? $value['nickName'] : $faker->userName;
        $user->setNickName($nickName);
        
        //userName
        $userName = isset($value['userName']) ? $value['userName'] : $faker->userName;
        $user->setUserName($userName);
        
        //realName
        $realName = isset($value['realName']) ? $value['realName'] : $faker->name;
        $user->setRealName($realName);
        return $user;
    }
}
```

#### mock数据: 放置mock对象

在`Controller`应用层文件中. 如果是列表生成一组`mock`对象, 如果是单个生成单个对象.

应用层文件接口应该为:

```php
1. mock对象(后期从仓库获取)
2. view
```

也就是后期我们把从仓库获取的对象替换掉`mock`对象, 但是`view`层不应该变.

#### 真实接口对接: 创建适配器

在`Adapter/User`文件夹内, 创建接口(interface). 接口设计需要考虑接口分离原则, 每个接口小而精悍. 常量都必须定义在接口内.

这里可以参见代码`Member/Adapter/User/IUserAdapter.class.php`.

使用具体的`UserRestfulAdapter`实现`IUserAdapter`. 这个类负责具体的实现.

#### 真实接口对接: 创建翻译器

创建`Member/Translator/UserRestfulTranslator.class.php`翻译器. 翻译从后端接口返回的数据.

#### 真实接口对接: 创建仓库

在`Member/Repository/User`文件夹内, 创建`UserRepository.class.php`文件. 该文件用于封装接口. 外界对象只调用仓库类, 不关心使用哪个`adapter`实现. 

#### 真实接口对接: 应用层调用仓库

在应用调用仓库, 把最早的`mock`对象改为真实接口对象.

### 修改数据操作

修改数据操作统一抽象为`Command`->`CommandHandler`->`领域对象 or 领域服务`->`基础设施`.

`Command`为封装应用请求命令.

#### 修改数据操作: 应用层设计

应用层构建函数:

1. `public function xxx`函数, 对应路由.
2. `protected function xxxView()`输出模板.
3. `protected function xxxAction()`构建提交的数据. 
4. `private function validatexxxScenario()`验证请求.

#### 修改数据操作: 构建命令处理器和模型

通过`Command`传输数据,`CommandHandler`负责调用领域模型和领域服务.

领域模型和领域服务实现具体的操作.

这里的具体操作就是调用仓库的修改操作. 比如示例中的注册.