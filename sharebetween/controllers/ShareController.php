<?php

namespace humhub\modules\sharebetween\controllers;

use Yii;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\sharebetween\models\Share;

use humhub\modules\space\models;
use humhub\components\LogManager;

use humhub\compat\HForm;
use humhub\modules\space\models\Membership;

class ShareController extends \humhub\components\Controller
{
    
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::class
            ]
        ];
    }
    
    public function actionIndex()
    {
        $error = null;
        $space = new ShareForm();
        $content = Content::findOne(['id' => Yii::$app->request->get('id')]);
        
        if (Yii::$app->request->isPost) {
            $form = Yii::$app->request->post('ShareForm');
            if (isset($form['guids']) && is_array($form['guids'])) {
                $shareQueue = [];
                $userSpaces = Membership::getUserSpaceQuery(Yii::$app->user->getIdentity())->select('guid')->column();
                foreach ($form['guids'] as $guid) {
                    if (in_array($guid, $userSpaces)) {
                        $shareSpace = \humhub\modules\space\models\Space::findOne(['guid' => $guid]);
                        if ($shareSpace) {
                            $shareQueue[] = $shareSpace;
                        }
                    } else {
                        $error = Yii::t('SharebetweenModule.base', 'You are not a member of all of these spaces.');
                        break;
                    }
                }

                if (!empty($shareQueue)) {
                    foreach ($shareQueue as $shareSpace) {
                        Share::create($content, $shareSpace); 
                    }

                    return $this->renderAjax('success');
                }
            } else {
                $error = Yii::t('SharebetweenModule.base', 'Please select a space to share into');
            }
        }
        
        return $this->renderAjax('index', [
            'space' => $space,
            'content' => $content,
            'error'=> $error
        ]);
    }
    
}










