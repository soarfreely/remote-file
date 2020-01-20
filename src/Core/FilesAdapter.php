<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile\Core;


use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use Soarfreely\RemoteFile\Config\Config;
use Soarfreely\RemoteFile\Exception\ConfigNotException;

abstract class FilesAdapter
{
    /**
     * @var array
     */
    protected $fileList  = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Filesystem|null
     */
    private static $filesystem = null;

    /**
     * FilesAdapter constructor.
     * @param Config $config
     * @throws ConfigNotException
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        self::$filesystem = FilesAdapterFactory::instance($config);

        $this->fileList($config->getDir());
    }

    /**
     * 获取指定目录的文件列表
     *
     * @param string $dir
     * @return array
     */
    private function fileList($dir = '')
    {
        return $this->fileList = self::$filesystem->listContents($dir);
    }

    /**
     * 获取指定文件的基础信息
     *
     * @param array $filenames 包含文件后缀
     * @return \Generator
     */
    public function listFileByName(array $filenames)
    {
        foreach ($filenames as $filename) {
            $filename = trim($filename);
            foreach ($this->fileList as $key => $item) {
                if($item['basename'] == $filename) {
                    yield $item;
                }
            }
        }
    }

    /**
     * 获取指定的文件
     *
     * @param string $filename
     * @return array|mixed
     */
    public function getFileByName(string $filename)
    {
        $filename = trim($filename);
        $temp = array_column($this->fileList, null,  'basename');
        return isset($temp[$filename]) ? $temp[$filename] : [];
    }

    /**
     * 获取文件句柄
     *
     * @param string $path
     * @return bool|false|mixed|resource
     * @throws FileNotFoundException
     */
    public function getFileHandle(string $path)
    {
        return self::$filesystem->readStream($path);
    }

}
