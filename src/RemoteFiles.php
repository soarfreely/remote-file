<?php

declare(strict_types=1);

namespace Soarfreely\RemoteFile;


use League\Flysystem\FileNotFoundException;
use Soarfreely\RemoteFile\Config\Config;
use Soarfreely\RemoteFile\Core\FilesAdapter;
use Soarfreely\RemoteFile\Exception\ConfigNotException;
use Soarfreely\RemoteFile\FileType\FileFactory;


class RemoteFiles extends FilesAdapter
{
    /**
     * RemoteFiles constructor.
     * @param Config $config
     * @throws ConfigNotException
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);
    }

    /**
     * 获取多个文件路径
     *
     * @param array $filenames
     * @return array
     */
    public function listPathByFilename(array $filenames)
    {
        $filePaths = [];
        foreach ($filenames as $key => $filename) {
            foreach ($this->listFileByName($filenames) as $item) {
                if ($item['basename'] == $filename) {
                    $filePaths[$key] = $item['path'];
                }

                if (array_values($filenames) === array_values($filePaths)) {
                    break 2;
                }
            }
        }

        return $filePaths;
    }

    /**
     * 获取多个文件句柄
     *
     * @param array $filenames
     * @return array
     */
    public function listHandlesByFilename(array $filenames)
    {
        $filesInfo = $this->listPathByFilename($filenames);
        array_walk($filesInfo, function (&$value) {
            $value = $this->getFileHandle($value);
        });

        return $filesInfo;
    }

    /**
     * 获取指定的文件句柄
     *
     * @param string $filename
     * @return bool|false|mixed|resource
     * @throws FileNotFoundException
     */
    public function getHandleByFilename(string $filename)
    {
        $filesInfo = $this->listPathByFilename([$filename]);
        return $this->getFileHandle($filesInfo[0]);
    }

    /**
     * 获取指定文件的行
     *
     * @param $handle
     * @param string $fileType
     * @param string $delimiter
     * @return \Generator
     */
    public function getLine($handle, string $fileType, string $delimiter)
    {
        $file = FileFactory::create($fileType);

        while (!feof($handle)) {
            yield $file->readLine($handle, $delimiter);
        }
    }

}
