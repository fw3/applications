# Flywheel3 Application library

Rapid Development FrameworkであるFlywheel3 の応用処理ライブラリです。

対象となるPHPのバージョンは7.2.0以上です。

## 導入方法

`composer require fw3/applications`としてインストールできます。

[Packagist](https://packagist.org/packages/fw3/applications)

## 主な機能

### 計算機

四則演算と簡易的な集約、数学関数を使える計算機です。
表計算ソフトウェアのような計算を行いたいが、PhpSpreadsheetを使うほどでもない場合に好適です。

#### 中置記法計算機：InfixCalculator

日本では一般的な中置記法で記述された式を計算する計算機です。
簡易的な集約、数学関数、実行時の値の置換を行えます。

次の例のようなそこそこ複雑な式も取り扱えます。

```php
<?php

use fw3\applications\calculator\InfixCalculator;

var_dump([
    InfixCalculator::calculate('1 + 2 - 3 * 4 / 5'),
    InfixCalculator::calculate('1 + 2 - 3 * 4 / 5 % 6'),
    InfixCalculator::calculate('(SUM(1,2,3) + 4 - MIN(1,2,3)) * MAX(1,2,3) / POW(2,POW(2,1))'),
]);

var_dump([
    InfixCalculator::calculate('A1 + B2', ['A1' => 1, 'B2' => 2]),
]);
```

#### 後置記法計算機：PostfixCalculator

ソフトウェアの世界ではよく見る後置記法（逆ポーランド記法）で記述された式を計算する計算機です。
後置記法計算機では関数や実行時の値の置換は行えません。

！！注意！！
それぞれのスタック間は半角スペースでセパレートされている必要があります。

```php
<?php

use fw3\applications\calculator\PostfixCalculator;

var_dump([
    PostfixCalculator::calculate('1 2 + 3 4 * 5 / -'),
    PostfixCalculator::calculate('12 34 +'),
]);
```
