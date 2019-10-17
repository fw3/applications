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

namespace fw3\tests\applications\calculator\traits;

use PHPUnit\Framework\TestCase;
use fw3\applications\calculator\InfixCalculator;

/**
 * 計算機特性のテスト
 */
class CalculatorTraitTest extends TestCase
{
    /**
     * 算術演算を行います。のテスト
     */
    public function testCalculateArithmetic() : void
    {
        $this->assertSame(2.0, InfixCalculator::calculateArithmetic(1, InfixCalculator::ARITH_OP_ADD, 1));
        $this->assertSame(2.0, InfixCalculator::calculateArithmetic(1.0, InfixCalculator::ARITH_OP_ADD, 1.0));
        $this->assertSame(2.0, InfixCalculator::calculateArithmetic('1', InfixCalculator::ARITH_OP_ADD, '1'));
        $this->assertSame(2.0, InfixCalculator::calculateArithmetic('1.0', InfixCalculator::ARITH_OP_ADD, '1.0'));
        $this->assertSame(2.0, InfixCalculator::calculateArithmetic('1.0', InfixCalculator::ARITH_OP_ADD, 1));
        $this->assertSame(2.0, InfixCalculator::calculateArithmetic(1, InfixCalculator::ARITH_OP_ADD, '1.0'));
        $this->assertSame(2.2, InfixCalculator::calculateArithmetic('1.1', InfixCalculator::ARITH_OP_ADD, 1.1));

        $this->assertSame(0.0, InfixCalculator::calculateArithmetic('1.1', InfixCalculator::ARITH_OP_SUB, 1.1));

        $this->assertSame(4.840000000000001, InfixCalculator::calculateArithmetic('2.2', InfixCalculator::ARITH_OP_MULTI, 2.2));

        $this->assertSame(1.0, InfixCalculator::calculateArithmetic('2.2', InfixCalculator::ARITH_OP_DIV, 2.2));

        $this->assertSame(0.0, InfixCalculator::calculateArithmetic('2.2', InfixCalculator::ARITH_OP_MOD, 2.2));

        try {
            InfixCalculator::calculateArithmetic('2.2', 'あ', 1);
        } catch (\Exception $e) {
            $this->assertSame('未定義の算術演算子を指定されました。2.2 あ 1', $e->getMessage());
        }

        try {
            InfixCalculator::calculateArithmetic('2.2', InfixCalculator::ARITH_OP_DIV, 0);
        } catch (\Exception $e) {
            $this->assertSame('ゼロ除算を実行しようとしました。2.2 / 0', $e->getMessage());
        }
    }

    /**
     * 比較演算を行います。のテスト
     */
    public function testComparison() : void
    {
        $this->assertTrue(InfixCalculator::comparison(1, InfixCalculator::COMP_OP_EQ, 1));
        $this->assertTrue(InfixCalculator::comparison(1, InfixCalculator::COMP_OP_EQ, 1.0));
        $this->assertTrue(InfixCalculator::comparison(1.0, InfixCalculator::COMP_OP_EQ, 1));
        $this->assertTrue(InfixCalculator::comparison('1', InfixCalculator::COMP_OP_EQ, '1'));

        $this->assertFalse(InfixCalculator::comparison('1', InfixCalculator::COMP_OP_EQ, ''));
    }

    /**
     * 数学関数を実行します。のテスト
     */
    public function testCalculateMathFunctions() : void
    {
        $replace_value_list = [];

        $numerical_formula  = 'POW(2, 1 + 1)';
        $this->assertSame('4', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'POW(2, 2)';
        $this->assertSame('4', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'POW(POW(2, 2), 2)';
        $this->assertSame('16', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'POW(2, POW(2, 2))';
        $this->assertSame('16', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'POW(2, POW(2, POW(2, 1)), POW(POW(2, 1), POW(2, 1)))';
        $this->assertSame('16', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'POW(2, 2)';
        $this->assertSame('4', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'LOG(10)';
        $this->assertSame('2.302585092994', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'LOG(10, 2)';
        $this->assertSame('3.3219280948874', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'SQRT(10)';
        $this->assertSame('3.1622776601684', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'SIN(10)';
        $this->assertSame('-0.54402111088937', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'TAN(10)';
        $this->assertSame('0.64836082745909', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'COS(10)';
        $this->assertSame('-0.83907152907645', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'CEIL(0.4)';
        $this->assertSame('1', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'CEIL(0.5)';
        $this->assertSame('1', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'CEIL(0.9)';
        $this->assertSame('1', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'FLOOR(0.4)';
        $this->assertSame('0', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'FLOOR(0.5)';
        $this->assertSame('0', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'FLOOR(0.9)';
        $this->assertSame('0', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'ROUND(0.1)';
        $this->assertSame('0', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'ROUND(0.4)';
        $this->assertSame('0', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'ROUND(0.5)';
        $this->assertSame('1', InfixCalculator::calculateMathFunctions($numerical_formula, $replace_value_list));
    }

    /**
     * 集約関数を実行します。のテスト
     */
    public function testCalculateAggregateFunctions() : void
    {
        $replace_value_list = [];

        $numerical_formula  = 'CNT(1, 1, 1)';
        $this->assertSame('3', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'CNT(CNT(1, 1, 1), CNT(1, 1, 1), CNT(1, 1, 1))';
        $this->assertSame('3', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'SUM(1, 2, 3)';
        $this->assertSame('6', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'SUM(SUM(1, 2, 3), SUM(SUM(1, 2), SUM(3, 4)), 3)';
        $this->assertSame('19', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'AVG(1, 2, 3)';
        $this->assertSame('2', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'MIN(1, 2, 3)';
        $this->assertSame('1', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'MAX(1, 2, 3)';
        $this->assertSame('3', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'CNT(1, 1, 1) + SUM(1, 2, 3) - AVG(1, 2, 3) * MIN(1, 2, 3) / MAX(1, 2, 3)';
        $this->assertSame('3 + 6 - 2 * 1 / 3', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'AVG(1, 5, 10)';
        $this->assertSame('5.3333333333333', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));

        $numerical_formula  = 'COUNT(1, 1, 1) + SUM(1, 2, 3) - AVG(1, 5, 10) * MIN(1, 2, 3) / MAX(1, 2, 3)';
        $this->assertSame('3 + 6 - 5.3333333333333 * 1 / 3', InfixCalculator::calculateAggregateFunctions($numerical_formula, $replace_value_list));
    }

    /**
     * 中置記法の計算式を後置記法（逆ポーランド記法）の計算式に変換します。のテスト
     */
    public function testInfixToPostfix() : void
    {
        $numerical_formula  = '1';
        $this->assertSame([1.0], InfixCalculator::infixToPostfix($numerical_formula));

        $numerical_formula  = '1 + 2 + (3 + 4)';
        $this->assertSame([1.0, 2.0, '+', 3.0, 4.0, '+', '+'], InfixCalculator::infixToPostfix($numerical_formula));

        $numerical_formula  = '(1 + 2) * (3 - 4)';
        $this->assertSame([1.0, 2.0, '+', 3.0, 4.0, '-', '*'], InfixCalculator::infixToPostfix($numerical_formula));

        $numerical_formula  = '1 + (2 * 3) - 4';
        $this->assertSame([1.0, 2.0, 3.0, '*', '+', 4.0, '-'], InfixCalculator::infixToPostfix($numerical_formula));

        $numerical_formula  = '1 + 2 * 3 - 4';
        $this->assertSame([1.0, 2.0, 3.0, '*', '+', 4.0, '-'], InfixCalculator::infixToPostfix($numerical_formula));

        $numerical_formula  = '1 + 2 - 3 * 4 / 5';
        $this->assertSame([1.0, 2.0, '+', 3.0, 4.0, '*', 5.0, '/', '-'], InfixCalculator::infixToPostfix($numerical_formula));
    }

    /**
     * 配列を後置記法として計算します。のテスト。
     */
    public function testCalculatePostfix() : void
    {
        $formulas   = [1.0];
        $this->assertSame(1.0, InfixCalculator::calculatePostfix($formulas));

        $formulas   = [1.0, 2.0, '+', 3.0, 4.0, '+', '+'];
        $this->assertSame(10.0, InfixCalculator::calculatePostfix($formulas));

        $formulas   = [1.0, 2.0, '+', 3.0, 4.0, '-', '*'];
        $this->assertSame(-3.0, InfixCalculator::calculatePostfix($formulas));

        $formulas   = [1.0, 2.0, 3.0, '*', '+', 4.0, '-'];
        $this->assertSame(3.0, InfixCalculator::calculatePostfix($formulas));

        $formulas   = [1.0, 2.0, 3.0, '*', '+', 4.0, '-'];
        $this->assertSame(3.0, InfixCalculator::calculatePostfix($formulas));

        $formulas   = [1.0, 2.0, '+', 3.0, 4.0, '*', 5.0, '/', '-'];
        $this->assertSame(0.6000000000000001, InfixCalculator::calculatePostfix($formulas));
    }
}
