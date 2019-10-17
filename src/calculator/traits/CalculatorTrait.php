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

namespace fw3\applications\calculator\traits;

/**
 * 計算機特性
 */
trait CalculatorTrait
{
    //==============================================
    // static property
    //==============================================
    /**
     * @var string  文字列長を得る場合などに使う、文字エンコード
     */
    protected static $encoding  = null;

    /**
     * @var string  使用を差し止める関数
     */
    protected static $denyFunctions = [];

    //==============================================
    // static method
    //==============================================
    /**
     * 文字列長を得る場合などに使う、文字エンコードを設定・取得します。
     *
     * @param   string  $encoding   文字列長を得る場合などに使う、文字エンコード
     * @return  string  文字列長を得る場合などに使う、文字エンコードまたはこのクラスパス
     */
    public static function encoding($encoding = null) : string
    {
        if (\func_num_args() === 0) {
            return static::$encoding;
        }
        static::$encoding   = $encoding;
        return static::class;
    }

    /**
     * 使用を差し止める関数を設定・取得します。
     *
     * @param   array           $deny_functions 使用を差し止める関数
     * @return  array|string    使用を差し止める関数またはこのクラスパス
     */
    public static function denyFunctions(?array $deny_functions = null)
    {
        if (\func_num_args() === 0) {
            return static::$denyFunctions;
        }
        static::$denyFunctions  = $deny_functions;
        return static::class;
    }

    /**
     * 数学関数を実行します。
     *
     * @param   array   $numerical_formula  計算対象リスト
     * @param   array   $replace_value_list 特定文字表現の置換対象値リスト
     * @return  array   数学関数を実行し、反映した計算対象リスト
     */
    public static function calculateMathFunctions(string $numerical_formula, array $replace_value_list = []) : string
    {
        $enable_deny_functions  = !empty(static::$denyFunctions);

        if ($enable_deny_functions && in_array(static::MATH_FUNC, static::$denyFunctions, true)) {
            return $numerical_formula;
        }

        $callback   = function ($matches) use ($enable_deny_functions, $replace_value_list) {
            $values     = null;

            $func_name  = $matches[1];

            if ($enable_deny_functions && in_array($func_name, static::$denyFunctions, true)) {
                return $matches[0];
            }

            $values     = \explode(',', $matches[2]);

            foreach ($values as $idx => $value) {
                $values[$idx] = static::calculate(\trim($value), $replace_value_list);
            }

            switch ($func_name) {
                case static::MATH_FUNC_POW:
                    return (string) \pow((float) $values[0], (float) $values[1]);
                case static::MATH_FUNC_LOG:
                    return (string) (isset($values[1]) ? \log((float) $values[0], (float) $values[1]) : \log((float) $values[0]));
                case static::MATH_FUNC_SQRT:
                    return (string) \sqrt((float) $values[0]);
                case static::MATH_FUNC_SIN:
                    return (string) \sin((float) $values[0]);
                case static::MATH_FUNC_TAN:
                    return (string) \tan((float) $values[0]);
                case static::MATH_FUNC_COS:
                    return (string) \cos((float) $values[0]);
                case static::MATH_FUNC_CEIL:
                    return (string) \ceil((float) $values[0]);
                case static::MATH_FUNC_FLOOR:
                    return (string) \floor((float) $values[0]);
                case static::MATH_FUNC_ROUND:
                    if (isset($values[2])) {
                        return (string) \round((float) $values[0], (int) $values[1], (int) $values[2]);
                    }
                    if (isset($values[1])) {
                        return (string) \round((float) $values[0], (int) $values[1]);
                    }
                    return (string) \round((float) $values[0]);
            }
        };

        for (
            $before_numerical_formula = null;
            $before_numerical_formula !== $numerical_formula;
            $before_numerical_formula = $numerical_formula,
            $numerical_formula = \preg_replace_callback("/(?:(POW|LOG|SQRT|SIN|TAN|COS|CEIL|FLOOR|ROUND)\w*\(([^()]+|(?R)+)\))/", $callback, $numerical_formula)
        );

        return $numerical_formula;
    }

    /**
     * 集約関数を実行します。
     *
     * @param   array   $numerical_formula  集約対象の計算対象リスト
     * @param   array   $replace_value_list 特定文字表現の置換対象値リスト
     * @return  array   集約関数を実行し、反映した計算対象リスト
     */
    public static function calculateAggregateFunctions(string $numerical_formula, array $replace_value_list = []) : string
    {
        $enable_deny_functions  = !empty(static::$denyFunctions);

        if ($enable_deny_functions && in_array(static::AGGR_FUNC, static::$denyFunctions, true)) {
            return $numerical_formula;
        }

        $callback = function ($matches) use ($enable_deny_functions, $replace_value_list) {
            $values     = null;

            $func_name  = $matches[1];

            if ($enable_deny_functions && in_array($func_name, static::$denyFunctions, true)) {
                return $matches[0];
            }

            $values     = \explode(',', $matches[2]);

            foreach ($values as $idx => $value) {
                $values[$idx] = static::calculate(\trim($value), $replace_value_list);
            }

            switch ($func_name) {
                case static::AGGR_FUNC_COUNT:
                case static::AGGR_FUNC_CNT:
                    return (string) \count($values);
                case static::AGGR_FUNC_SUM:
                    return (string) \array_sum($values);
                case static::AGGR_FUNC_AVG:
                    return (string) (\array_sum($values) / \count($values));
                case static::AGGR_FUNC_MIN:
                    \sort($values);
                    return (string) \reset($values);
                case static::AGGR_FUNC_MAX:
                    \sort($values);
                    return (string) \end($values);
            }
        };

        for (
            $before_numerical_formula = null;
            $before_numerical_formula !== $numerical_formula;
            $before_numerical_formula = $numerical_formula,
            $numerical_formula = \preg_replace_callback("/(?:(COUNT|CNT|SUM|AVG|MIN|MAX)\w*\(([^()]+|(?R)+)\))/", $callback, $numerical_formula)
        );

        return $numerical_formula;
    }

    /**
     * 算術演算を行います。
     *
     * @param   int|float   $operand_left   左辺値
     * @param   string      $operator       演算子
     * @param   int|float   $operand_right  右辺値
     * @return  float       計算結果
     */
    public static function calculateArithmetic($operand_left, string $operator, $operand_right) : float
    {
        $operand_left   = (float) $operand_left;
        $operand_right  = (float) $operand_right;

        switch ($operator) {
            case static::ARITH_OP_ADD:
                return $operand_left + $operand_right;
            case static::ARITH_OP_SUB:
                return $operand_left - $operand_right;
            case static::ARITH_OP_MULTI:
                return $operand_left * $operand_right;
            case static::ARITH_OP_DIV:
                if ($operand_right === 0.0) {
                    throw new \Exception(\sprintf('ゼロ除算を実行しようとしました。%s %s %s', $operand_left, $operator, $operand_right));
                }
                return $operand_left / $operand_right;
            case static::ARITH_OP_MOD:
                return $operand_left % $operand_right;
        }

        throw new \Exception(\sprintf('未定義の算術演算子を指定されました。%s %s %s', $operand_left, $operator, $operand_right));
    }

    /**
     * 比較演算を行います。
     *
     * @param   mixed   $operand_left       左辺値
     * @param   string  $operator           比較演算子
     * @param   mixed   $operand_right      右辺値
     * @param   array   $replace_value_list 値置換用配列
     * @return  bool    比較演算結果
     */
    public static function comparison($operand_left, string $operator, $operand_right, array $replace_value_list = []) : bool
    {
        //値のどちらかがnullの場合は即死
        if ($operand_left === null || $operand_right === null) {
            return false;
        }

        //左辺値のフォーマット
        $operand_left = static::calculate((string) $operand_left, $replace_value_list);

        //右辺値のフォーマット
        $operand_right = static::calculate((string) $operand_right, $replace_value_list);

        if ($operand_left === false || $operand_right === false) {
            return false;
        }

        //対象となる比較演算子がない場合はfalse
        if (!isset(static::COMP_OP_LIST[$operator])) {
            return false;
        }

        // データ有無チェック
        switch ($operator) {
            case static::COMP_OP_SEQ:
            case static::COMP_OP_EQ:
            case static::COMP_OP_N_EQ:
            case static::COMP_OP_N_SEQ:
            case static::COMP_OP_LT:
            case static::COMP_OP_LT_EQ:
            case static::COMP_OP_GT:
            case static::COMP_OP_GT_EQ:
            case static::COMP_OP_REGEX:
                if ($operand_left === null) {
                    return false;
                }

                if ($operand_left === '') {
                    return false;
                }

                if ($operand_right === null) {
                    return false;
                }

                if ($operand_right === '') {
                    return false;
                }
        }

        //比較演算
        switch ($operator) {
            case static::COMP_OP_SEQ:
                return $operand_left    === $operand_right;
            case static::COMP_OP_EQ:
                return $operand_left    ==  $operand_right;
            case static::COMP_OP_N_SEQ:
                return $operand_left    !== $operand_right;
            case static::COMP_OP_N_EQ:
                return $operand_left    !=  $operand_right;
            case static::COMP_OP_LT:
                return $operand_left    <   $operand_right;
            case static::COMP_OP_LT_EQ:
                return $operand_left    <=  $operand_right;
            case static::COMP_OP_GT:
                return $operand_left    >   $operand_right;
            case static::COMP_OP_GT_EQ:
                return $operand_left    >=  $operand_right;
            case static::COMP_OP_ANY:
                return $operand_left    !=  null && ($operand_left != '' || $operand_left === 0);
            case static::COMP_OP_EMPTY:
                return $operand_left    ==  null || ($operand_left == '' && $operand_left !== 0);
            case static::COMP_OP_REGEX:
                return \preg_match('@'. \str_replace('@', '\\@', $operand_right) .'@', $operand_left) === 1;
        }
    }

    /**
     * 中置記法の計算式を後置記法（逆ポーランド記法）の計算式に変換します。
     *
     * @param   string  $numerical_formula  中値記法の計算式
     * @param   array   $replace_value_list 値置換用配列
     * @return  array   後置記法（逆ポーランド記法）化された計算式
     */
    public static function infixToPostfix(string $numerical_formula, array $replace_value_list = []) : array
    {
        $encoding   = static::$encoding ?? \mb_internal_encoding();

        // 数式展開
        $postfix_formula    = null;
        if (\preg_match_all("/\-?[A-Za-z]+\d+|\-?\d+\.\d+|[0]|\-?[1-9][0-9]*|[\(\)\+\-\/\*%]/", $numerical_formula, $postfix_formula) === 0) {
            return [$numerical_formula];
        }
        $postfix_formula    = $postfix_formula[0];

        // 数値の符号対応（マイナスの数値が渡ってきた場合＝演算子が続いた場合、符号と判断し、結合してセットする）
        $op_adjuster = [];
        for ($i = 0, $postfix_formula_length = \count($postfix_formula); $i < $postfix_formula_length; $i++) {
            $formula    = $postfix_formula[$i];

            if (isset(static::ARITH_OP_LIST[$formula])) {
                if ($i === 0) {
                    $op_adjuster[] = $formula . $postfix_formula[++$i];
                    continue;
                }

                if (isset(static::ARITH_OP_LIST[$postfix_formula[$i + 1]]) && $i + 2 < $postfix_formula_length) {
                    $op_adjuster[] = $formula;
                    $op_adjuster[] = $postfix_formula[++$i] . $postfix_formula[++$i];
                    continue;
                }
            }

            if (isset(static::ARITH_OP_LIST[$formula])) {
                $op_adjuster[] = $formula;
                continue;
            }

            if (isset(static::PAREN_LIST[$formula])) {
                $op_adjuster[] = $formula;
                continue;
            }

            $operator   = '';
            if (\mb_substr($formula, 0, 1, $encoding) === '-') {
                $operator   = '-';
                $formula    = \mb_substr($formula, 1, $encoding);
            }

            $formula    = !isset($replace_value_list[$formula]) ? (float) $formula : static::calculate((string) $replace_value_list[$formula], $replace_value_list);
            $op_adjuster[]  = ($operator === '-' ? -1.0 : 1.0) * $formula;
        }
        $postfix_formula = $op_adjuster;

        // 逆ポーランド記法化
        $stack  = [];
        $polish = [];

        foreach ($postfix_formula as $chunk) {
            if ($chunk === static::PAREN_START) {
                $stack[] = $chunk;
                continue;
            }

            if ($chunk === static::PAREN_END) {
                while (!empty($stack)) {
                    if (\end($stack) === static::PAREN_START) {
                        break;
                    }
                    $polish[] = \array_pop($stack);
                }
                \array_pop($stack);
                continue;
            }

            while (!empty($stack)) {
                if ((static::OP_PRIORITY_LIST[$chunk] ?? static::OPERATOR_PRIORITY_LOWEST) > (static::OP_PRIORITY_LIST[\end($stack)] ?? static::OPERATOR_PRIORITY_LOWEST)) {
                    break;
                }
                $polish[] = \array_pop($stack);
            }

            $stack[] = $chunk;
        }

        while (!empty($stack)) {
            $polish[] = \array_pop($stack);
        }

        return $polish;
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
