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

namespace fw3\applications\calculator\interfaces;

/**
 * 計算機インターフェース。
 */
interface CalculatorInterface
{
    //==============================================
    // const
    //==============================================
    // 比較演算子
    //----------------------------------------------
    /**
     * @var string  比較演算子コード：===
     */
    public const COMP_OP_SEQ    = '===';

    /**
     * @var string  比較演算子コード：==
     */
    public const COMP_OP_EQ    = '==';

    /**
     * @var string  比較演算子コード：!==
     */
    public const COMP_OP_N_SEQ  = '!==';

    /**
     * @var string  比較演算子コード：!=
     */
    public const COMP_OP_N_EQ  = '!=';

    /**
     * @var string  比較演算子コード：<
     */
    public const COMP_OP_LT    = '<';

    /**
     * @var string  比較演算子コード：<=
     */
    public const COMP_OP_LT_EQ = '<=';

    /**
     * @var string  比較演算子コード：>
     */
    public const COMP_OP_GT    = '>';

    /**
     * @var string  比較演算子コード：>=
     */
    public const COMP_OP_GT_EQ = '>=';

    /**
     * @var string  比較演算子コード：REGEX
     */
    public const COMP_OP_REGEX = 'regex';

    /**
     * @var string  比較演算子コード：ANY
     */
    public const COMP_OP_ANY   = 'any';

    /**
     * @var string  比較演算子コード：EMPTY
     */
    public const COMP_OP_EMPTY = 'empty';

    /**
     * @var array   比較演算子リスト
     */
    public const COMP_OP_LIST   = [
        self::COMP_OP_SEQ   => self::COMP_OP_SEQ,
        self::COMP_OP_EQ    => self::COMP_OP_EQ,
        self::COMP_OP_N_SEQ => self::COMP_OP_N_SEQ,
        self::COMP_OP_N_EQ  => self::COMP_OP_N_EQ,
        self::COMP_OP_LT    => self::COMP_OP_LT,
        self::COMP_OP_LT_EQ => self::COMP_OP_LT_EQ,
        self::COMP_OP_GT    => self::COMP_OP_GT,
        self::COMP_OP_GT_EQ => self::COMP_OP_GT_EQ,
        self::COMP_OP_REGEX => self::COMP_OP_REGEX,
        self::COMP_OP_ANY   => self::COMP_OP_ANY,
        self::COMP_OP_EMPTY => self::COMP_OP_EMPTY,
    ];

    //----------------------------------------------
    // 算術演算子
    //----------------------------------------------
    /**
     * @var string  算術演算子：加算
     */
    public const ARITH_OP_ADD   = '+';

    /**
     * @var string  算術演算子：減算
     */
    public const ARITH_OP_SUB   = '-';

    /**
     * @var string  算術演算子：乗算
     */
    public const ARITH_OP_MULTI = '*';

    /**
     * @var string  算術演算子：除算
     */
    public const ARITH_OP_DIV   = '/';

    /**
     * @var string  算術演算子：剰余算
     */
    public const ARITH_OP_MOD   = '%';

    /**
     * @var string  丸括弧：始め
     */
    public const PAREN_START    = '(';

    /**
     * @var string  丸括弧：終わり
     */
    public const PAREN_END      = ')';

    /**
     * @var array   算術演算子リスト
     */
    public const ARITH_OP_LIST  = [
        self::ARITH_OP_ADD      => self::ARITH_OP_ADD,
        self::ARITH_OP_SUB      => self::ARITH_OP_SUB,
        self::ARITH_OP_MULTI    => self::ARITH_OP_MULTI,
        self::ARITH_OP_DIV      => self::ARITH_OP_DIV,
        self::ARITH_OP_MOD      => self::ARITH_OP_MOD,
    ];

    /**
     * @var array   演算子優先順位リスト
     */
    public const OP_PRIORITY_LIST   = [
        self::PAREN_START       => 1,
        self::ARITH_OP_ADD      => 2,
        self::ARITH_OP_SUB      => 2,
        self::ARITH_OP_MULTI    => 3,
        self::ARITH_OP_DIV      => 3,
        self::ARITH_OP_MOD      => 3,
    ];

    /**
     * @var int     演算子の優先順位：最低
     */
    public const OPERATOR_PRIORITY_LOWEST   = 4;

    /**
     * @var array   丸括弧リスト
     */
    public const PAREN_LIST  = [
        self::PAREN_START   => self::PAREN_START,
        self::PAREN_END     => self::PAREN_END,
    ];

    //----------------------------------------------
    // 数学関数
    //----------------------------------------------
    /**
     * @var string  数学関数：指数表現
     */
    public const MATH_FUNC_POW  = 'POW';

    /**
     * @var string  数学関数：自然対数
     */
    public const MATH_FUNC_LOG  = 'LOG';

    /**
     * @var string  数学関数：平方根
     */
    public const MATH_FUNC_SQRT = 'SQRT';

    /**
     * @var string  数学関数：正弦（サイン）
     */
    public const MATH_FUNC_SIN  = 'SIN';

    /**
     * @var string  数学関数：正接（タンジェント）
     */
    public const MATH_FUNC_TAN  = 'TAN';

    /**
     * @var string  数学関数：余弦（コサイン）
     */
    public const MATH_FUNC_COS  = 'COS';

    /**
     * @var string  数学関数：端数の切り上げ
     */
    public const MATH_FUNC_CEIL     = 'CEIL';

    /**
     * @var string  数学関数：端数の切り上げ
     */
    public const MATH_FUNC_FLOOR    = 'FLOOR';

    /**
     * @var string  数学関数：浮動小数点数を丸める
     */
    public const MATH_FUNC_ROUND    = 'ROUND';

    /**
     * @var array   数学関数リスト
     */
    public const MATH_FUNC_LIST = [
        self::MATH_FUNC_POW     => self::MATH_FUNC_POW,
        self::MATH_FUNC_LOG     => self::MATH_FUNC_LOG,
        self::MATH_FUNC_SQRT    => self::MATH_FUNC_SQRT,
        self::MATH_FUNC_SIN     => self::MATH_FUNC_SIN,
        self::MATH_FUNC_TAN     => self::MATH_FUNC_TAN,
        self::MATH_FUNC_COS     => self::MATH_FUNC_COS,
        self::MATH_FUNC_CEIL    => self::MATH_FUNC_CEIL,
        self::MATH_FUNC_FLOOR   => self::MATH_FUNC_FLOOR,
        self::MATH_FUNC_ROUND   => self::MATH_FUNC_ROUND,
    ];

    //----------------------------------------------
    // 集約関数
    //----------------------------------------------
    /**
     * @var string  集約関数：含まれる要素数
     */
    public const AGGR_FUNC_COUNT    = 'COUNT';

    /**
     * @var string  集約関数：含まれる要素数の省略表記
     */
    public const AGGR_FUNC_CNT      = 'CNT';

    /**
     * @var string  集約関数：合計
     */
    public const AGGR_FUNC_SUM      = 'SUM';

    /**
     * @var string  集約関数：平均
     */
    public const AGGR_FUNC_AVG      = 'AVG';

    /**
     * @var string  集約関数：最小値
     */
    public const AGGR_FUNC_MIN      = 'MIN';

    /**
     * @var string  集約関数：最大値
     */
    public const AGGR_FUNC_MAX      = 'MAX';

    /**
     * @var array   集約関数リスト
     */
    public const AGGR_FUNC_LIST = [
        self::AGGR_FUNC_COUNT   => self::AGGR_FUNC_COUNT,
        self::AGGR_FUNC_CNT     => self::AGGR_FUNC_CNT,
        self::AGGR_FUNC_SUM     => self::AGGR_FUNC_SUM,
        self::AGGR_FUNC_AVG     => self::AGGR_FUNC_AVG,
        self::AGGR_FUNC_MIN     => self::AGGR_FUNC_MIN,
        self::AGGR_FUNC_MAX     => self::AGGR_FUNC_MAX,
    ];

    //==============================================
    // static method
    //==============================================
    /**
     * 文字列長を得る場合などに使う、文字エンコードを設定・取得します。
     *
     * @param   string  $encoding   文字列長を得る場合などに使う、文字エンコード
     * @return  string  文字列長を得る場合などに使う、文字エンコードまたはこのクラスパス
     */
    public static function encoding($encoding = null) : string;

    /**
     * 数学関数を実行します。
     *
     * @param   array   $numerical_formula  計算対象リスト
     * @param   array   $replace_value_list 特定文字表現の置換対象値リスト
     * @return  array   数学関数を実行し、反映した計算対象リスト
     */
    public static function calculateMathFunctions(string $numerical_formula, array $replace_value_list = []) : string;

    /**
     * 集約関数を実行します。
     *
     * @param   array   $numerical_formula  集約対象の計算対象リスト
     * @param   array   $replace_value_list 特定文字表現の置換対象値リスト
     * @return  array   集約関数を実行し、反映した計算対象リスト
     */
    public static function calculateAggregateFunctions(string $numerical_formula, array $replace_value_list = []) : string;

    /**
     * 算術演算を行います。
     *
     * @param   int|float   $operand_left   左辺値
     * @param   string      $operator       演算子
     * @param   int|float   $operand_right  右辺値
     * @return  float       計算結果
     */
    public static function calculateArithmetic($operand_left, string $operator, $operand_right) : float;

    /**
     * 比較演算を行います。
     *
     * @param   mixed   $operand_left       左辺値
     * @param   string  $operator           比較演算子
     * @param   mixed   $operand_right      右辺値
     * @param   array   $replace_value_list 値置換用配列
     * @return  bool    比較演算結果
     */
    public static function comparison($operand_left, string $operator, $operand_right, array $replace_value_list = []) : bool;

    /**
     * 計算します。
     *
     * @param   string  $calc_formula       計算式
     * @param   array   $replace_value_list 特定文字列に対する置換用配列
     * @return  float   計算結果
     */
    public static function calculate(string $calc_formula, array $replace_value_list = []) : float;

    /**
     * 配列を後置記法として計算します。
     *
     * @param   array   $formulas   後置記法の計算式配列
     * @return  float   計算結果
     */
    public static function calculatePostfix(array $formulas) : float;
}
