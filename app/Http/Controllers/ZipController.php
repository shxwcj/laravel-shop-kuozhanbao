<?php

namespace App\Http\Controllers;

use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ZipController extends Controller
{
    /**
     * 显示日志列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $logs = File::files(storage_path('logs'));
        return view('zip.index', compact('logs'));
    }

    /**
     * 处理批量下载
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function download(Request $request)
    {
        //打包文件名
        $name = 'logs-' . time();

        //创建zip文件
        $zipper = (new Zipper)->make($name)->folder('logs');

        foreach ($request->logs as $log) {
            //坚持文件是否存在
            $path = storage_path('logs/' . basename($log));
            if (!File::exists($path)) {
                continue;
            }

            //将文件加入zip包
            $zipper->add($path);
        }
        //关闭zip
        $zipper->close();

        // 返回下载响应，下载完成后删除文件
        return response()->download(public_path($name))->deleteFileAfterSend(true);
    }

    /**
     * 处理 Zip 文件上传和解压
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function upload(Request $request)
    {
        if ($request->logs) {
        $zipper = (new Zipper)->make($request->logs);

        // 可以使用 listFiles() 查看 zip 文件内容
        logger('zip file list:');
        logger($zipper->listFiles());
        $zipper->folder('logs')->extractMatchingRegex(storage_path('logs'), '/\.log$/');
        }

        return redirect()->route('zip.index');
    }
}
