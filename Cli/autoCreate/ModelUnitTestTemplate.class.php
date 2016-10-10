<?php

class ModelUnitTestTemplate implements TemplateInterface{

	private $profileData;
	private $buffer;

	//测试用邮箱
	public $testEmail;
	//测试用手机号
	public $testCellPhone;
	//测试用整型
	public $testInt;
	//测试用字符串
	public $testString;
	//测试用时间
	public $testTime;
	//测试用数组
	public $testArray;
	//测试用QQ
	public $testQq;

	public function __construct(){
		$this->testEmail = '41893204@qq.com';
		$this->testCellPhone = '15202939435';
		$this->testInt = 1;
		$this->testString = 'string';
		$this->testTime = time();
		$this->testArray = 'array(1, 2, 3)';
		$this->testQq = '41893204';
	}

	public function __destruct(){
		unset($this->testEmail);
		unset($this->testCellPhone);
		unset($this->testInt);
		unset($this->testString);
		unset($this->testTime);
		unset($this->testArray);
		unset($this->testQq);
	}

	/**
	 * 加载配置文件信息
	 */
	public function loadProfile($profile){
		if(is_file('Cli/autoCreate/Profile/'.$profile.'.php')){
			$this->profileData = include 'Cli/autoCreate/Profile/'.$profile.'.php';
			return true;
		}
		return false;
	}

	public function generate(){

		$this->generateBeginInfo();
		$this->generateConstructFunction();
		$this->generateSetGetFunctions();
		$this->generateEndInfo();

		return file_put_contents('Cli/autoCreate/UnitTest/'.$this->profileData['className'].'Test.php', $this->buffer);
	}

	/**
	 * 生成文件开始信息
	 */
	public function generateBeginInfo(){
		$this->buffer .= "<?php";
		$this->buffer .= "\nnamespace ".$this->profileData['nameSpace'].";";
        $this->buffer .= "\n\n";
        $this->buffer .= "use tests;";
        $this->buffer .= "\n";
		$this->buffer .= "\n/**";
		$this->buffer .= "\n * \\".$this->profileData['nameSpace']."\\".$this->profileData['className'].'class.php 测试文件';
		$this->buffer .= "\n * @author chloroplast";
		$this->buffer .= "\n * @version 1.0.0:".date('Y.m.d', time());
		$this->buffer .= "\n */";
		$this->buffer .= "\n\nclass ".$this->profileData['className']."Test extends tests\GenericTestCase";
        $this->buffer .= "\n{";
		$this->buffer .= "\n";
		$this->buffer .= "    private ".'$stub'.";\n";
		$this->buffer .= "\n";
		$this->buffer .= "    public function setUp()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub = new ".$this->profileData['className']."();\n";
		$this->buffer .= "    }\n";
	}

	/**
	 * 生成文件结束信息
	 */
	public function generateEndInfo(){
		$this->buffer .= "}\n";
	}

	/**
	 * 生成构造函数
	 */
	private function generateConstructFunction(){
		$this->buffer .= "\n";
		$this->buffer .= "    /**\n     * ".$this->profileData['className']." ".$this->profileData['comment'].", 测试构造函数"."\n     */\n";
		$this->buffer .= "    public function test".$this->profileData['className']."Constructor()\n";
        $this->buffer .= "    {\n";
		foreach($this->profileData['parameters'] as $parameter){
			$default = $parameter['default'] !== '' ? $parameter['default'] : "''";
			//注释
			$this->buffer .= "        //测试初始化".$parameter['comment']."\n";
			$this->buffer .= "        ".'$'.$parameter['key']."Parameter = ".'$'."this->getPrivateProperty('\\".$this->profileData['nameSpace']."\\".$this->profileData['className']."', '".$parameter['key']."');\n";
			if($parameter['type'] == 'int'){//整型
				if($parameter['rule'] == 'time'){
					$this->buffer .= "        ".'$'."this->assertGreaterThan(0, ".'$'.$parameter['key']."Parameter->getValue(".'$'."this->stub));\n";	
				}else{
					$this->buffer .= "        ".'$'."this->assertEquals(".$parameter['default'].", ".'$'.$parameter['key']."Parameter->getValue(".'$'."this->stub));\n";
				}
			}else if($parameter['type'] == 'string'){//字符
				if($parameter['default'] == ''){
					$this->buffer .= "        ".'$'."this->assertEmpty(".'$'.$parameter['key']."Parameter->getValue(".'$'."this->stub));\n";
				}
			}else{//如果规则是对象
				if($parameter['rule'] == 'object'){
					$this->buffer .= "        ".'$'."this->assertInstanceof('".$parameter['type']."', ".'$'.$parameter['key']."Parameter->getValue(".'$'."this->stub));\n";
				}
			}
			$this->buffer .= "\n";
		}
		$this->buffer .= "    }\n";
	}

	/**
	 * 生成测试整型函数用例
	 */
	private function generateTestSetIntFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."($this->testInt);\n";
		$this->buffer .= "        ".'$'."this->assertEquals($this->testInt, ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testString');\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加错误类型测试函数 -- 结束
		//测试错误类型但是是数字 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型.但是传参是数值, 期望返回类型正确, 值正确."."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongTypeButNumeric()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testInt');\n";
		$this->buffer .= "        ".'$'."this->assertTrue(is_int(".'$'."this->stub->get".ucfirst($parameter['key'])."()));\n";
		$this->buffer .= "        ".'$'."this->assertEquals($this->testInt, ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		//测试错误类型但是是数字 -- 结束
	}

	/**
	 * 生成测试时间函数用例
	 */
	private function generateTestSetTimeFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."($this->testTime);\n";
		$this->buffer .= "        ".'$'."this->assertEquals($this->testTime, ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testString');\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加错误类型测试函数 -- 结束
		//测试错误类型但是是时间 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型.但是传参是数值, 期望返回类型正确, 值正确."."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongTypeButNumeric()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testTime');\n";
		$this->buffer .= "        ".'$'."this->assertTrue(is_int(".'$'."this->stub->get".ucfirst($parameter['key'])."()));\n";
		$this->buffer .= "        ".'$'."this->assertEquals($this->testTime, ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		//测试错误类型但是是时间 -- 结束
	}

	/**
	 * 生成测试字符串函数用例
	 */
	private function generateTestSetStringFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testString');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('$this->testString', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."($this->testArray);\n";
		$this->buffer .= "    }\n";
		//添加错误类型测试函数 -- 结束
	}

	/**
	 * 生成测试Email函数用例
	 */
	private function generateTestSetEmailFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testEmail');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('$this->testEmail', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."($this->testArray);\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加错误类型测试函数 -- 结束
		//测试正确类型但是不符合邮件格式, 期望返回空 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型.但是传参是数值, 期望返回类型正确, 值正确."."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectTypeButNotEmail()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testString');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		//测试正确类型但是不符合邮件格式, 期望返回空 -- 结束
	}

	 /**
	 * 生成测试CellPhone函数用例
	 */
	private function generateTestSetCellPhoneFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testCellPhone');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('$this->testCellPhone', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."($this->testArray);\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加错误类型测试函数 -- 结束
		//测试正确类型但是不是数字, 期望返回空 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 但是不属于手机格式, 期望返回空."."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectTypeButNotCellPhone()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testCellPhone'.'a');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		//测试正确类型但是不是数字, 期望返回空 -- 结束
	}

	/**
	 * 生成测试QQ函数用例
	 */
	private function generateTestSetQQFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testQq');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('$this->testQq', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."($this->testArray);\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加错误类型测试函数 -- 结束
		//测试正确类型但是不是数字, 期望返回空 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 但是不属于QQ格式, 期望返回空."."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectTypeButNotQQ()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testString');\n";
		$this->buffer .= "        ".'$'."this->assertEquals('', ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		//测试正确类型但是不是数字, 期望返回空 -- 结束
	}	

	/**
	 * 生成测试对象函数用例
	 */
	private function generateTestObjectFunction($parameter){
		$this->buffer .= "\n";

		//添加正确类型测试函数 -- 开始
		//添加正确类型测试函数注释
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 正确的传参类型, 期望传值正确"."\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."CorrectType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."object = new ".$parameter['type']."();";
		$this->buffer .= "        //根据需求自己添加对象的设置, 如果需要\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."(".'$'."object);\n";
		$this->buffer .= "        ".'$'."this->assertSame(".'$'."object, ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加正确类型测试函数 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."(".'$'."this->testSring);\n";
		$this->buffer .= "    }\n";
		//添加错误类型测试函数 -- 结束
	}

	/**
	 * 生成测试范围函数用例
	 */
	private function generateTestRangeFunction($parameter){
		$this->buffer .= "\n";

		//添加循环预定范围测试 -- 开始
		$this->buffer .= "    /**\n     * 循环测试 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 是否符合预定范围"."\n     *\n     * @dataProvider ".$parameter['key']."Provider\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."(".'$'."actual, ".'$'."expected)\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."(".'$'."actual);\n";
		$this->buffer .= "        ".'$'."this->assertEquals(".'$'."expected, ".'$'."this->stub->get".ucfirst($parameter['key'])."()".");\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//生成数据构建器
		$this->buffer .= "    /**\n     * 循环测试 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 数据构建器\n     */\n";
		$this->buffer .= "    public function ".$parameter['key']."Provider()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        return [\n";
		foreach($parameter['rule'] as $rule){
			$this->buffer .= "            [".$rule.",".$rule."],\n";
		}
		//测试默认值
		$this->buffer .= "            [9999,".$parameter['default']."],\n";
		$this->buffer .= "        ];\n";
		$this->buffer .= "    }\n";
		$this->buffer .= "\n";
		//添加循环预定范围测试 -- 结束
		//添加错误类型测试函数 -- 开始
		$this->buffer .= "    /**\n     * 设置 ".$this->profileData['className']." set".ucfirst($parameter['key'])."() 错误的传参类型, 期望期望抛出TypeError exception\n     *\n     * @expectedException TypeError\n     */\n";
		$this->buffer .= "    public function testSet".ucfirst($parameter['key'])."WrongType()\n";
        $this->buffer .= "    {\n";
		$this->buffer .= "        ".'$'."this->stub->set".ucfirst($parameter['key'])."('$this->testString');\n";
		$this->buffer .= "    }\n";
		//添加错误类型测试函数 -- 结束
	}

	private function generateSetGetFunctions(){
		$this->buffer .= "\n";

		foreach($this->profileData['parameters'] as $parameter){
			//添加注释分隔符, 用于表示每个变量的测试开始
			$this->buffer .= "    //".$parameter['key']." 测试 ";
			$max = 60 - strlen($parameter['key']);
			for($i = 0; $i < $max; $i++){
				$this->buffer .= '-';
			}

			$this->buffer .= " start";
			if($parameter['type'] == 'int'){//整型
				if($parameter['rule'] == 'int'){
					$this->generateTestSetIntFunction($parameter);
				}elseif($parameter['rule'] == 'time'){
					$this->generateTestSetTimeFunction($parameter);
				}elseif(is_array($parameter['rule'])){//测试范围
					$this->generateTestRangeFunction($parameter);
				}
			}else if($parameter['type'] == 'string'){//字符
				if($parameter['rule'] == '' || $parameter['rule'] == 'string'){
					$this->generateTestSetStringFunction($parameter);
				}elseif($parameter['rule'] == 'email'){
					$this->generateTestSetEmailFunction($parameter);
				}elseif($parameter['rule'] == 'cellPhone'){
					$this->generateTestSetCellPhoneFunction($parameter);
				}elseif($parameter['rule'] == 'qq'){
					$this->generateTestSetQQFunction($parameter);
				}
			}else{//如果规则是对象
				if($parameter['rule'] == 'object'){
					$this->generateTestObjectFunction($parameter);	
				}
			}
			//添加注释分隔符, 用于表示每个变量的测试结束
			$this->buffer .= "    //".$parameter['key']." 测试 ";
			$max = 60 - strlen($parameter['key']);
			for($i = 0; $i < $max; $i++){
				$this->buffer .= '-';
			}
			$this->buffer .= "   end\n";
		}
	}
}
