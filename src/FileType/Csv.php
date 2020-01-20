<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile\FileType;


class Csv implements FileInterface
{

    /**
     * @inheritDoc
     */
    public function readLine($handle, $delimiter)
    {
        return fgetcsv($handle, 4096, $delimiter);
    }
}