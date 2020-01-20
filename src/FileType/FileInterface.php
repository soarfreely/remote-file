<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile\FileType;


interface FileInterface
{
    /**
     * @param $handle
     * @param $delimiter
     * User: <zhangxiang_php@vchangyi.com>
     * @return mixed
     */
    public function readLine($handle, $delimiter);
}