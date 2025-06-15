<?php
/* */

namespace InnoShop\Front\Controllers;

use InnoShop\Front\Requests\UploadFileRequest;
use InnoShop\Front\Requests\UploadImageRequest;
use InnoShop\RestAPI\Services\UploadService;

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
        $data = UploadService::getInstance()->images($request);

        return json_success('上传成功', $data);
    }

    /**
     * Upload document files
     *
     * @param  UploadFileRequest  $request
     * @return mixed
     */
    public function docs(UploadFileRequest $request): mixed
    {
        $data = UploadService::getInstance()->files($request);

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
        $data = UploadService::getInstance()->files($request);

        return json_success('上传成功', $data);
    }
}
