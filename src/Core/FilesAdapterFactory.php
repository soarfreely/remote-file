<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile\Core;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Soarfreely\RemoteFile\Config\Config;
use Soarfreely\RemoteFile\Exception\ConfigNotException;

class FilesAdapterFactory
{
    /**
     * @var array | Filesystem
     */
    private static $sftpObject = [];

    /**
     * @param Config $config
     * @return mixed
     * @throws ConfigNotException
     */
    public static function instance(Config $config)
    {
        $configure = $config->getConfig();
        if (empty($configure)) {
            throw new ConfigNotException('config not found');
        }

        $key = md5(json_encode(ksort($configure)));
        if (!isset(self::$sftpObject[$key]) || !self::$sftpObject[$key] instanceof Filesystem) {
            self::$sftpObject[$key] = new Filesystem(new SftpAdapter($configure), ['visibility' => 'public']);
        }
        return self::$sftpObject[$key];
    }
}