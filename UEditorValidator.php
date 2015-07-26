<?php
namespace gerpayt\yii2_ueditor;

use Yii;
use yii\helpers\Html;
use yii\validators\RequiredValidator;
use yii\validators\ValidationAsset;


class UEditorValidator extends RequiredValidator
{
    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = [];
        if ($this->requiredValue !== null) {
            $options['message'] = Yii::$app->getI18n()->format($this->message, [
                'requiredValue' => $this->requiredValue,
            ], Yii::$app->language);
            $options['requiredValue'] = $this->requiredValue;
        } else {
            $options['message'] = $this->message;
        }
        if ($this->strict) {
            $options['strict'] = 1;
        }

        $options['message'] = Yii::$app->getI18n()->format($options['message'], [
            'attribute' => $model->getAttributeLabel($attribute),
        ], Yii::$app->language);

        ValidationAsset::register($view);

        $id = Html::getInputId($model, $attribute);

        // TODO require validation
        return '
        yii.validation.required(UE.getEditor("'.$id.'").getContent(), messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
