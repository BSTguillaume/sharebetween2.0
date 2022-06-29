<?php

namespace humhub\modules\sharebetween;

use humhub\modules\sharebetween\models\Share;

class Module extends \humhub\components\Module
{

    /**
     * @inheritdoc
     */
    public function disable()
    {
        foreach (Share::find()->all() as $share) {
            $share->delete();
        }

        parent::disable();
    }

}
