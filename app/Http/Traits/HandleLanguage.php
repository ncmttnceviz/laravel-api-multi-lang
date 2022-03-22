<?php

namespace App\Http\Traits;

use App\Models\Language;

trait HandleLanguage
{
    public function getCurrentLang()
    {
        $shortCode = isset($_GET['lang']) ? $_GET['lang'] : null;
        $language = (new Language())->where('short_code',$shortCode)->first();

        if($shortCode && $language){
            return $language->id;
        }

        return $this->getMainLang();
    }

    public function getMainLang()
    {
        $language = (new Language())->where('is_main',1)->first();
        return $language->id;
    }
}
