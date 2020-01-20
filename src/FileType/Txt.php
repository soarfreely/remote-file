<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile\FileType;


class Txt implements FileInterface
{

    /**
     * @inheritDoc
     */
    public function readLine($handle, $delimiter)
    {
        $line = fgets($handle, 4096);
        !empty($line) && $line = explode($delimiter, $line);
        return $line;
    }
}