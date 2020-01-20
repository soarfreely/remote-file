<?php
/**
 * User: <zhangxiang_php@vchangyi.com>
 * Date: 2020/1/17 Time: 下午3:31
 */
namespace Soarfreely\RemoteFile\Test;

use League\Flysystem\FileNotFoundException;
use Soarfreely\RemoteFile\Config\Config;
use Soarfreely\RemoteFile\Exception\RemoteFileException;
use Soarfreely\RemoteFile\RemoteFiles;

require_once '../vendor/autoload.php';

class Test
{
    public function index()
    {
        $config =  [
            'host'          => '127.0.0.1',
            'port'          => 22,
            'username'      => 'user',
            'password'      => 'pass',
            'privateKey'    => '',
            'root'          => '/sftp',
            'timeout'       => 10,
            'directoryPerm' => 0755
        ];

        $filenames = [
            'sftp_demo_2020-12-31.txt',
            'sftp_demo_2020-12-30.txt',
        ];

        $client = null;
        $handle = null;

        try {
            $config = Config::create($config);
            $client = new RemoteFiles($config);

            // 获取多个文件句柄
            $handleList = $client->listHandlesByFilename($filenames);
            print_r($handleList);
            echo PHP_EOL;

            // 获取指定文件句柄
            $handle = $client->getFileHandle('sftp_demo_2010-01-01.txt');
            print_r($handle);
            echo PHP_EOL;
        } catch (RemoteFileException $e) {
            print_r($e);
        } catch (FileNotFoundException $e) {
            print_r($e);
        }

        // 获取行内容
        if ($client instanceof RemoteFiles && is_resource($handle)) {
            $lineGenerator = $client->getLine($handle, 'txt', "\t");
            foreach ($lineGenerator as $line) {
                print_r($line);
                break;
            }
        }
    }
}

$test = new Test();
$test->index();

// 上述代码输出如下
/*
    Array
    (
        [0] => Resource id #40
        [1] => Resource id #41
    )

    Resource id #42
    Array
    (
        [0] => 22302bb8e6ffa8d
        [1] => AYAM0017860607
        [2] => 122PPG1906_br_舒肤佳
        [3] => 109417642
        [4] => 122PPG1906_br_舒肤佳
        [5] => 20
        [6] => 69
        [7] =>
        [8] => 2019-12-09
    )
*/

