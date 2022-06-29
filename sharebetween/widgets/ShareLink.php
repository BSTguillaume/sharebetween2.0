<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\widgets;

use humhub\components\Widget;
use Yii;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\sharebetween\models\Share;

class ShareLink extends Widget
{

    /**
     * @var \humhub\modules\content\components\ContentActiveRecord
     */
    public $content;

    /**
     * Executes the widget.
     */
    public function run()
    {
        if ($this->content instanceof Share || !Share::canShare($this->content->content)) {
            return;
        }
        
        return $this->render('shareLink', [
            'object' => $this->content,
            'id' => $this->content->content->id,
        ]);
    }

}
