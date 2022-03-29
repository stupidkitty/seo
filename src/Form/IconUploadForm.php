<?php
namespace SK\SeoModule\Form;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * IconUploadForm represents the model behind the search form about.
 */
class IconUploadForm extends Model
{
    public ?UploadedFile $icon;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            //[['icon'], 'required'],
            [['icon'], 'image', 'skipOnEmpty' => false, 'extensions' => ['ico', 'png'], 'checkExtensionByMimeType' => false],
        ];
    }
    /**
     * @inheritdoc
     */
    public function formName(): string
    {
    	return '';
    }

    public function isValid(): bool
    {
        $this->icon = UploadedFile::getInstance($this, 'icon');

        return $this->validate();
    }
}
