<?php

/**
 * @copyright Copyright (C) 2015-2023 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

declare(strict_types=1);

namespace statink\yii2\calHeatmap;

use yii\web\AssetBundle;

final class CalHeatmapAsset extends AssetBundle
{
    /**
     * @var string $sourcePath
     */
    public $sourcePath = '@npm/cal-heatmap/dist';

    /**
     * @var string[] $js
     */
    public $js = [
        'cal-heatmap.min.js',
    ];

    /**
     * @var string[] $css
     */
    public $css = [
        'cal-heatmap.css',
    ];

    /**
     * @var string[] $depends
     * @phpstan-var class-string<AssetBundle> $depends
     */
    public $depends = [
        D3Asset::class,
    ];
}
