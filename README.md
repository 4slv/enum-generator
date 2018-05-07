# enum-generator
Генератор кода класса перечисляемого типа Enum [myclabs/php-enum](https://github.com/myclabs/php-enum)

## Как использовать

**Пример:**
```php
use Slov\EnumGenerator\EnumElement;
use Slov\EnumGenerator\EnumGenerator;

require_once 'vendor/autoload.php';

$projectPath = '/tmp/enum-generator';
$enumClassName = 'Sex';
$enumNamespace = 'Enum';
$enumClassComment = 'Пол';
$enumCodeDirRelativePath = 'enum';
$enumElementList = [
    (new EnumElement())->setName('MALE')->setValue('Male')->setComment('Мужчина'),
    (new EnumElement())->setName('FEMALE')->setValue('Female')->setComment('Женщина')
];

$enumGenerator = new EnumGenerator();
$enumGenerator
    ->setProjectPath($projectPath) // $projectPath абсолютный путь к папке проекта
    ->setClassName($enumClassName) // $enumClassName название класса с перечислениями
    ->setEnumNamespace($enumNamespace) // $enumNamespace пространство имен класса с перечислениями
    ->setClassComment($enumClassComment) // $enumClassComment комментарий к классу с перечислениями
    ->setEnumCodeRelativePath($enumCodeDirRelativePath) // $enumCodeDirRelativePath относительный путь к папке
    ->setEnumElementList($enumElementList) // $enumElementList список описания элементов перечисления
    ->generate(); // генерация класса
```

В результате сгенерируется файл:
/tmp/enum-generator/Sex.php

со следующим содержимым:
```php
<?php
namespace Enum;

use MyCLabs\Enum\Enum;

/** Пол */
class Sex extends Enum
{
    /** Мужчина */
    const MAN = 'Man';

    /** Женщина */
    const WOMAN = 'Women';
    
 }
```
