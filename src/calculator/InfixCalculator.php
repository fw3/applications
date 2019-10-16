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

namespace fw3\applications\calculator;

use fw3\applications\calculator\interfaces\CalculatorInterface;
use fw3\applications\calculator\traits\CalculatorTrait;

/**
 * 中置記法の計算式を用いて計算を行うクラス
 */
class InfixCalculator implements CalculatorInterface
{
    use CalculatorTrait;

    //==============================================
    // static method
    //==============================================
    /**
     * 計算します。
     *
     * @param   string  $calc_formula       計算式
     * @param   array   $replace_value_list 特定文字列に対する置換用配列
     * @return  float   計算結果
     */
    public static function calculate(string $calc_formula, array $replace_value_list = []) : float
    {
        if (isset($replace_value_list[$calc_formula])) {
            return (float) $replace_value_list[$calc_formula];
        }

        return (float)  PostfixCalculator::calculatePostfix(
            static::infixToPostfix(
                static::calculateAggregateFunctions(
                    static::calculateMathFunctions(
                        $calc_formula,
                        $replace_value_list
                    ),
                    $replace_value_list
                ),
                $replace_value_list
            )
        );
    }
}
