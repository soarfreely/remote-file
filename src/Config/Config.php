<?php

declare(strict_types=1);


namespace Soarfreely\RemoteFile\Config;



use Soarfreely\RemoteFile\Exception\ConfigNotException;

final class   Config
{
    /**
     * @var array
     */
    private static $config = [];

    /**
     * @var string
     */
    private static $dir = '';

    /**
     * @var string
     */
    private static $delimiter = '';

    /**
     * Config constructor.
     */
    private function __construct(){}

    /**
     * @param array $config
     * @param string $directory
     * @return Config
     * @throws ConfigNotException
     */
    public static function create(array $config, string $directory = ''):self
    {
        if (empty($config)) {
            throw new ConfigNotException('config not found');
        }

        $instance =  (new self());

        $instance->setConfig($config);
        $instance->setDir($directory);

        return $instance;
    }

    /**
     * @param array $config
     */

    public function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * @return mixed
     */
    public function getConfig():array
    {
        return self::$config;
    }

    /**
     * @param string $dir
     */
    public function setDir(string $dir)
    {
        self::$dir = $dir;
    }

    /**
     * @return string
     */
    public function getDir():string
    {
        return self::$dir;
    }

    /**
     * @param string $delimiter
     * User: <zhangxiang_php@vchangyi.com>
     */
    public function setDelimiter(string $delimiter)
    {
        self::$delimiter = $delimiter;
    }

    /**
     * User: <zhangxiang_php@vchangyi.com>
     * @return string
     * Date: 2019/12/10 Time: 上午11:25
     */
    public function getDelimiter()
    {
        return self::$delimiter;
    }
}