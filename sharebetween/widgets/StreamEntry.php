<?php

namespace humhub\modules\sharebetween\widgets;

use humhub\modules\content\widgets\stream\WallStreamEntryWidget;
use Yii;

/**
 * Shows a Task Wall Entry
 */
class StreamEntry extends WallStreamEntryWidget
{

    public $wallEntryLayout = "@sharebetween/widgets/views/wallEntry.php";

    protected function renderContent() {
        if (!is_null($this->model->sharedContent)) {
            return $this->render('streamEntry', [
                'share' => $this->model
            ]);
        }
    }
}
