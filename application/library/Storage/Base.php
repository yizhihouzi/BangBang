<?php
// 分布式文件存储类
class Storage_Base
{

    /**
     * 操作句柄
     * @var string
     * @access protected
     */
    static protected $handler;

    /**
     * 连接分布式文件系统
     * @access public
     * @param array $options 配置数组
     */
    static public function connect($options = array())
    {
        if (function_exists('saeAutoLoader')) {// 自动识别SAE环境
            self::$handler = new Storage_Sae($options);
        }else{
            self::$handler = new Storage_File($options);
        }
    }

    static public function __callstatic($method, $args)
    {
        //调用缓存驱动的方法
        if (method_exists(self::$handler, $method)) {
            return call_user_func_array(array(self::$handler, $method), $args);
        }
    }
}
