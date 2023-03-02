<?php

/**
 * @copyright Copyright (C) 2015-2023 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

declare(strict_types=1);

namespace statink\yii2\calHeatmap;

use yii\web\AssetBundle;

final class PopperAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@npm/popperjs--core/dist/umd';

    /**
     * @var string[]
     */
    public $js = [
        'popper.min.js',
    ];
}
