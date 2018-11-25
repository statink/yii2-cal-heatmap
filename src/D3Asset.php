<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

declare(strict_types=1);

namespace statink\yii2\calHeatmap;

use yii\web\AssetBundle;

class D3Asset extends AssetBundle
{
    public $sourcePath = '@npm/d3';
    public $js = [
        'd3.min.js',
    ];
}
