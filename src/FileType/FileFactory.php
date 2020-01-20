<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile\FileType;


class FileFactory
{
    /**
     * 类映射
     */
    const MAP = [
        'txt' => Txt::class,
        'csv' => Csv::class,
    ];

    /**
     * @var array
     */
    static private $instance = [];

    /**
     * @param string $type
     * User: <zhangxiang_php@vchangyi.com>
     * @return mixed
     */
    public static function create(string $type)
    {
        if (!isset(self::$instance[$type])) {
            $className = self::MAP[$type];
            self::$instance[$type] = new $className();
        }
        return self::$instance[$type];
    }
}