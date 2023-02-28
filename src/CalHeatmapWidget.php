<?php

/**
 * @copyright Copyright (C) 2015-2023 AIZAWA Hina
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
use yii\web\AssetManager;
use yii\web\View;

use function array_merge;
use function array_unshift;
use function preg_replace;
use function rawurlencode;
use function strtolower;
use function trim;
use function vsprintf;

class CalHeatmapWidget extends Widget
{
    /**
     * @var array<string, mixed>
     */
    public array $options = [];

    /**
     * @var array<string, mixed>
     */
    public array $jsOptions = [];

    /**
     * @var array<string, mixed>
     */
    public array $defaultJsOptions = [
        'animationDuration' => 0,
        'date' => [
            'locale' => null,
            'timezone' => null,
        ],
        'domain' => [
            'type' => 'month',
            'dynamicDimension' => true,
            'gutter' => 1,
            'padding' => [0, 0, 0, 0],
        ],
        'itemSelector' => null,
        'range' => 12,
        'subDomain' => [
            'gutter' => 2,
            'height' => 10,
            'radius' => 0,
            'type' => 'day',
            'width' => 10,
        ],
        'theme' => 'light',
        'verticalOrientation' => false,
    ];

    public function run(): string
    {
        $view = $this->view;
        if ($view instanceof View) {
            CalHeatmapAsset::register($view);
            $this->runJs($view);
        }

        return $this->runHtml();
    }

    protected function runJs(View $view): void
    {
        $options = ArrayHelper::merge(
            $this->defaultJsOptions,
            $this->jsOptions,
        );

        if ($options['itemSelector'] === null) {
            $options['itemSelector'] = '#' . $this->id;
        }

        if (ArrayHelper::getValue($options, 'date.locale', null) === null) {
            $locale = self::getDayjsLocaleName(strtolower((string)Yii::$app->language));
            if ($locale) {
                ArrayHelper::setValue($options, 'date.locale', $locale);
            }
        }

        if (ArrayHelper::getValue($options, 'date.timezone', null) === null) {
            ArrayHelper::setValue($options, 'date.timezone', Yii::$app->timeZone);
        }

        $view->registerJs(
            vsprintf('(new window.CalHeatmap()).paint(%s);', [
                Json::encode($options),
            ]),
        );
    }

    protected function runHtml(): string
    {
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Html::tag(
            $tag,
            '',
            array_merge(
                $options,
                ['id' => $this->id],
            ),
        );
    }

    protected static function getDayjsLocaleName(string $locale): string
    {
        $locale = preg_replace('/@.+$/', '', trim(strtolower($locale)));
        return match ($locale) {
            'ar-dz', 'ar-iq', 'ar-kw', 'ar-ly', 'ar-ma', 'ar-sa', 'ar-tn', 'bn-bd' => $locale,
            'de-at', 'de-ch', 'en-au', 'en-ca', 'en-gb', 'en-ie', 'en-il', 'en-in' => $locale,
            'en-nz', 'en-sg', 'en-tt', 'es-do', 'es-mx', 'es-pr', 'es-us', 'fr-ca' => $locale,
            'fr-ch', 'gom-latn', 'hy-am', 'it-ch', 'ms-my', 'nl-be', 'oc-lnc', 'pa-in' => $locale,
            'pt-br', 'sr-cyrl', 'sv-fi', 'tl-ph', 'tzm-latn', 'ug-cn', 'uz-latn' => $locale,
            'zh-cn', 'zh-hk', 'zh-tw' => $locale,
            default => (string)preg_replace('/^([a-z]+)-.+$/', '$1', $locale),
        };
    }
}
