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
use fw3\applications\calculator\InfixCalculator;

/**
 * 中置記法の計算式を用いて計算を行うクラスのテスト
 */
class InfixCalculatorTest extends TestCase
{
    /**
     * 計算します。のテスト
     */
    public function testCalculate() : void
    {
        $replace_value_list = [];

        $calc_formula       = '1.0';
        $this->assertSame(1.0, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 + 2';
        $this->assertSame(3.0, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 - 2';
        $this->assertSame(-1.0, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 * 2';
        $this->assertSame(2.0, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 / 2';
        $this->assertSame(0.5, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 % 2';
        $this->assertSame(1.0, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 + 2 - 3 * 4 / 5';
        $this->assertSame(0.6, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '1 + 2 - 3 * 4 / 5 % 6';
        $this->assertSame(1.0, InfixCalculator::calculate($calc_formula, $replace_value_list));

        $calc_formula       = '(SUM(1,2,3) + 4 - MIN(1,2,3)) * MAX(1,2,3) / POW(2,POW(2,1))';
        $this->assertSame(6.75, InfixCalculator::calculate($calc_formula, $replace_value_list));
    }
}
