<?php

namespace gerpayt\yii2_ueditor;

use yii\helpers\BaseHtml;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class UEditorWidget extends InputWidget
{
    public $height;

    public function run()
    {
        $options = $this->options;

        if (isset($options['id'])) {
            $id = $options['id'];
        } else {
            $id = 'editor';
        }

        if (isset($options['name'])) {
            $name = $options['name'];
        } elseif ($this->hasModel()) {
            $name = BaseHtml::getInputName($this->model, $this->attribute);
        } else {
            $name = $this->name;
        }

        if (isset($options['value'])) {
            $value = $options['value'];
        } elseif ($this->hasModel()) {
            $value = BaseHtml::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->hasModel() ? $this->model[$this->attribute] : $this->value;
        }

        echo Html::beginTag('script', ['id'=>$id, 'type'=>'text/plain', 'name' => $name, 'style' => "height:{$this->height}"]);
        echo $value;
        echo Html::endTag('script');

        $ueditorConfig = [
            'serverUrl' => Url::to(['ueditor/controller']),
        ];
        $config = Json::encode($ueditorConfig);

        $this->view->registerJs("var ue = UE.getEditor('{$id}', {$config});");
    }
}
