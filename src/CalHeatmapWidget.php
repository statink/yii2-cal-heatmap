<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

declare(strict_types=1);

namespace statink\yii2\calHeatmap;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class CalHeatmapWidget extends Widget
{
    public $options = [];
    public $jsOptions = [];
    public $defaultJsOptions = [
        'itemSelector' => null,
        'domain' => 'month',
        'subDomain' => 'day',
        'range' => 12,
        'cellSize' => 10,
        'cellPadding' => 2,
        'cellRadius' => 0,
        'domainGutter' => 2,
        'domainMargin' => [0, 0, 0, 0],
        'domainDynamicDimension' => true,
        'verticalOrientation' => false,
    ];

    public function run()
    {
        CalHeatmapAsset::register($this->view);
        $this->runJs();
        return $this->runHtml();
    }

    protected function runJs(): void
    {
        $options = array_merge($this->defaultJsOptions, $this->jsOptions);
        if ($options['itemSelector'] === null) {
            $options['itemSelector'] = '#' . $this->id;
        }
        $this->view->registerJs(sprintf(
            '(new CalHeatMap()).init(%s);',
            Json::encode($options)
        ));
    }

    protected function runHtml(): string
    {
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Html::tag($tag, '', array_merge(
            $options,
            ['id' => $this->id]
        ));
    }
}
