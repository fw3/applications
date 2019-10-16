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
 * 後置記法（逆ポーランド記法）の計算式を用いて計算を行うクラス
 */
class PostfixCalculator implements CalculatorInterface
{
    use CalculatorTrait;

    //==============================================
    // static method
    //==============================================
    /**
     * 計算します。
     *
     * @param   string  $calc_formula       計算式 それぞれのスタック間は半角スペースでセパレートされている必要があります
     * @param   array   $replace_value_list 特定文字列に対する置換用配列
     * @return  float   計算結果
     */
    public static function calculate(string $calc_formula, array $replace_value_list = []) : float
    {
        return static::calculatePostfix(\explode(' ', $calc_formula));
    }

    /**
     * 配列を後置記法として計算します。
     *
     * @param   array   $formulas   後置記法の計算式配列
     * @return  float   計算結果
     */
    public static function calculatePostfix(array $formulas) : float
    {
        if (empty($formulas)) {
            return 0.0;
        }

        $stack  = [];

        foreach ($formulas as $operator) {
            switch ((string) $operator) {
                case static::ARITH_OP_ADD:
                case static::ARITH_OP_SUB:
                case static::ARITH_OP_MULTI:
                case static::ARITH_OP_DIV:
                case static::ARITH_OP_MOD:
                    $operand_right  = \array_pop($stack);
                    $operand_left   = \array_pop($stack);
                    $stack[] = static::calculateArithmetic($operand_left, $operator, $operand_right);
                    break;
                default:
                    $stack[] = $operator;
                    break;
            }
        }

        return (float) \end($stack);
    }
}
