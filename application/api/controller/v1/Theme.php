<?php

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\common\lib\exception\ThemeException;
use think\Controller;


class Theme extends Controller
{
    /**
     * @url theme?ids=id1,id2,id3...
     * @ 一组theme模型
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $res = ThemeModel::with(['topicImg', 'headImg'])->select($ids);
        if($res->isEmpty())
        {
            throw new ThemeException();
        }
        return $res;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme)
        {
            throw new ThemeException();
        }
        return $theme;
    }
}
