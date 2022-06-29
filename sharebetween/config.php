<?php

use humhub\modules\content\widgets\WallEntryControls;
use humhub\modules\content\models\Content;

return [
    'id' => 'sharebetween',
    'class' => 'humhub\modules\sharebetween\Module',
    'namespace' => 'humhub\modules\sharebetween',
    'events' => [
        [
            'class' => Content::class, 
            'event' => Content::EVENT_BEFORE_DELETE, 
            'callback' => ['humhub\modules\sharebetween\Events', 'onContentDelete']
        ],
        [
            'class' => WallEntryControls::class, 
            'event' => WallEntryControls::EVENT_INIT, 
            'callback' => ['humhub\modules\sharebetween\Events', 'onWallEntryControlsInit']
        ],
    ],
];
