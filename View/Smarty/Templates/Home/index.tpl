<!DOCTYPE html>
<html>
<head>
<meta content="xxx" name="csrf-token">
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<script>
//设置AJAX的全局默认选项
$.ajaxSetup( {
    url: "/index.html" , // 默认URL
    aysnc: false , // 默认同步加载
    type: "POST" , // 默认使用POST方式
    headers: { // 默认添加请求头
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    } ,
    error: function(jqXHR, textStatus, errorMsg){ // 出错时默认的处理函数
        // jqXHR 是经过jQuery封装的XMLHttpRequest对象
        // textStatus 可能为： null、"timeout"、"error"、"abort"或"parsererror"
        // errorMsg 可能为： "Not Found"、"Internal Server Error"等

        // 提示形如：发送AJAX请求到"/index.html"时出错[404]：Not Found
        alert( '发送AJAX请求到"' + this.url + '"时出错[' + jqXHR.status + ']：' + errorMsg );        
    }
} );

$.ajax( {
url: "/" ,
type: "GET" ,
success: function( data, textStatus, jqXHR ){
alert("返回数据：" + data);
} ,
error: function(jqXHR, textStatus, errorMsg){
alert("自己的error!");        
}
});

</script>
</body>
</html>
