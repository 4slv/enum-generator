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
    (new EnumElement())->setName('MALE')->setValue('Male')->setValue('Мужчина'),
    (new EnumElement())->setName('FEMALE')->setValue('Female')->setValue('Женщина')
];

$enumGenerator = new EnumGenerator();
$enumGenerator->setProjectPath($projectPath); // $projectPath абсолютный путь к папке проекта
$enumGenerator->setClassName($enumClassName); // $enumClassName название класса с перечислениями
$enumGenerator->setEnumNamespace($enumNamespace); // $enumNamespace пространство имен класса с перечислениями
$enumGenerator->setClassComment($enumClassComment); // $enumClassComment комментарий к классу с перечислениями
$enumGenerator->setEnumCodeRelativePath($enumCodeDirRelativePath); // $enumCodeDirRelativePath относительный путь к папке
$enumGenerator->setEnumElementList($enumElementList); // $enumElementList список описания элементов перечисления
$enumGenerator->generate(); // генерация класса
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
