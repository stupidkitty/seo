<?php
namespace SK\SeoModule\Form;

use yii\base\Model;

/**
 * IconUploadForm represents the model behind the search form about.
 */
class IconUploadForm extends Model
{
    public $icon;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['icon'], 'required'],
            [['icon'], 'image', 'skipOnEmpty' => false, 'extensions' => ['ico', 'png']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function formName()
    {
    	return '';
    }

    public function isValid()
    {
        return $this->validate();
    }
}
