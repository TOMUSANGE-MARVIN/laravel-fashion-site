<?php
/* */

namespace InnoShop\Panel\Controllers;

use InnoShop\Panel\Requests\UploadFileRequest;
use InnoShop\Panel\Requests\UploadImageRequest;

class UploadController
{
    /**
     * Upload images.
     *
     * @param  UploadImageRequest  $request
     * @return mixed
     */
    public function images(UploadImageRequest $request): mixed
    {
        $image    = $request->file('image');
        $type     = $request->file('type', 'common');
        $filePath = $image->store("/{$type}", 'catalog');
        $realPath = "catalog/$filePath";

        $data = [
            'url'   => asset($realPath),
            'value' => $realPath,
        ];

        return json_success('上传成功', $data);
    }

    /**
     * Upload document files
     *
     * @param  UploadFileRequest  $request
     * @return mixed
     */
    public function files(UploadFileRequest $request): mixed
    {
        $file     = $request->file('file');
        $type     = $request->file('type', 'files');
        $filePath = $file->store("/{$type}", 'catalog');
        $realPath = "catalog/$filePath";

        $data = [
            'url'   => asset($realPath),
            'value' => $realPath,
        ];

        return json_success('上传成功', $data);
    }
}
