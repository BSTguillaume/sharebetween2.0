<?php
namespace humhub\modules\sharebetween\models;

use humhub\modules\space\models\Space;
use humhub\modules\content\models\Content; //   Add 


use Yii;
use yii\base\Model;
/**
 * Description of ShareForm
 *
 * @author buddha modif Patman
 */
class ShareForm extends Model
{
    /**
     * An array representing all guids of the share form
     * @var array
     */
    public $guids;

}