<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

class IntroductionController extends BaseController
{
    public function index(): string
    {
        return 'This is Panel Restful APIs for '.innoshop_version();
    }
}
