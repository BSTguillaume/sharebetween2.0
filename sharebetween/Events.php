<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween;

use humhub\modules\content\models\Content;
use humhub\modules\post\models\Post;
use Yii;
use humhub\modules\sharebetween\widgets\ShareLink;
use humhub\modules\sharebetween\models\Share;
class Events
{

    public static function onWallEntryControlsInit($event)
    {
        $stackWidget = $event->sender;
        $content = $event->sender->object;

        $stackWidget->addWidget(ShareLink::class, ['content' => $content]);
    }

    /**
     * Delete relations to the Share object
     */
    public static function onContentDelete($event)
    {
        $content = $event->sender;
        if (!($content instanceof Content)) {
            return;
        }

        if ($content->object_model != Post::class) {
            return;
        }

        $shareIds = [];
        $shares = Share::findAll(['content_id' => $content->id]);
        foreach ($shares as $share) {
            $shareIds[] = $share->id;
        }

        if (empty($shareIds)) {
            return;
        }

        $shareContents = Content::find()->where(['object_model' => Share::class, 'object_id' => $shareIds])->all();
        foreach ($shareContents as $shareContent) {
            $shareContent->delete();
        }
    }

}
