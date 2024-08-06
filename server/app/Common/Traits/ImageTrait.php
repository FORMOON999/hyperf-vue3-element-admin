<?php

namespace App\Common\Traits;

use App\Common\Util\Upload\Helper\ImageHelper;
use Hyperf\Di\Annotation\Inject;
use function Hyperf\Support\make;

trait ImageTrait
{
    #[Inject]
    private ?ImageHelper $imageHelper = null;

    public function getImageHelper(): ImageHelper
    {
        if (is_null($this->imageHelper)) {
            $this->imageHelper = make(ImageHelper::class);
        }
        return $this->imageHelper;
    }
}