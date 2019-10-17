<?php
/**    _______       _______
 *    / ____/ |     / /__  /
 *   / /_   | | /| / / /_ <
 *  / __/   | |/ |/ /___/ /
 * /_/      |__/|__//____/
 *
 * Flywheel3: the inertia php framework
 *
 * @category    Flywheel3
 * @package     applications
 * @author      wakaba <wakabadou@gmail.com>
 * @copyright   Copyright (c) @2019  Wakabadou (http://www.wakabadou.net/) / Project ICKX (https://ickx.jp/). All rights reserved.
 * @license     http://opensource.org/licenses/MIT The MIT License.
 *              This software is released under the MIT License.
 * @varsion     1.0.0
 */

declare(strict_types=1);

namespace fw3\tests\applications\calculator;

use PHPUnit\Framework\TestCase;
use fw3\applications\calculator\PostfixCalculator;

/**
 * 後置記法（逆ポーランド記法）の計算式を用いて計算を行うクラスのテスト
 */
class PostfixCalculatorTest extends TestCase
{
    /**
     * 計算します。のテスト
     */
    public function testCalculate() : void
    {
        $calc_formula       = '';
        $replace_value_list = [];

        $calc_formula   = '1.0';
        $this->assertSame(1.0, PostfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula   = '1 2 + 3 4 * 5 / -';
        $this->assertSame(0.6, PostfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula   = '12 34 + 5 *';
        $this->assertSame(230.0, PostfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = 'SUM(1,2,3) 4 + MIN(1,2,3) - MAX(1,2,3) * POW(2,POW(2,1)) /';
        $this->assertSame(6.75, PostfixCalculator::calculate($calc_formula, $replace_value_list));
    }
}
