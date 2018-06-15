<?php

namespace EnumGenerator;

use EnumGenerator\Helper\StringHelper;

/** Генератор перечисляемого типа */
class EnumGenerator
{
    /**
     * @var EnumElement[] список элементов
     */
    protected $enumElementList = [];

    /** @var string путь к папке проекта */
    protected $projectPath;

    /** @var string относительный путь к папке в которой будет сгенерирован код перечисляемого типа */
    protected $enumCodeRelativePath;

    /** @var string пространство имён перечисляемого типа */
    protected $enumNamespace;

    /** @var string название класса */
    protected $className;

    /** @var string комментарий класса */
    protected $classComment;

    /**
     * @return EnumElement[] список элементов
     */
    public function getEnumElementList(): array
    {
        return $this->enumElementList;
    }

    /**
     * @param EnumElement[] $enumElementList список элементов
     * @return $this
     */
    public function setEnumElementList(array $enumElementList)
    {
        $this->enumElementList = $enumElementList;
        return $this;
    }

    /**
     * @return string путь к папке проекта
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }

    /**
     * @param string $projectPath путь к папке проекта
     * @return $this
     */
    public function setProjectPath($projectPath)
    {
        $this->projectPath = realpath($projectPath);
        return $this;
    }

    /**
     * @return string относительный путь к папке в которой будут сгенерирован код перечисляемого типа
     */
    protected function getEnumCodeRelativePath()
    {
        return $this->enumCodeRelativePath;
    }

    /**
     * @param string $enumCodeRelativePath относительный путь к папке в которой будут сгенерирован код перечисляемого типа
     * @return $this
     */
    public function setEnumCodeRelativePath($enumCodeRelativePath)
    {
        $this->enumCodeRelativePath = $enumCodeRelativePath;
        return $this;
    }

    /**
     * @return string пространство имён перечисляемого типа
     */
    public function getEnumNamespace()
    {
        return $this->enumNamespace;
    }

    /**
     * @param string $enumNamespace пространство имён перечисляемого типа
     * @return $this
     */
    public function setEnumNamespace($enumNamespace)
    {
        $this->enumNamespace = $enumNamespace;
        return $this;
    }

    /**
     * @return string название класса
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className название класса
     * @return $this
     */
    public function setClassName(string $className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @return string комментарий класса
     */
    public function getClassComment(): string
    {
        return $this->classComment;
    }

    /**
     * @param string $classComment комментарий класса
     * @return $this
     */
    public function setClassComment(string $classComment)
    {
        $this->classComment = $classComment;
        return $this;
    }

    /**
     * @param string $templateFileName имя файла шаблона
     * @return string содержимое шаблона
     */
    protected function getTemplateContent($templateFileName)
    {
        return file_get_contents(
            __DIR__ .
            DIRECTORY_SEPARATOR.
            'Templates'.
            DIRECTORY_SEPARATOR.
            $templateFileName
        );
    }

    /**
     * @return string шаблон класса
     */
    protected function getTemplateEnumClass()
    {
        return $this->getTemplateContent(
            'enumClass.txt'
        );
    }

    /**
     * @return string шаблон константы в перечислении
     */
    protected function getTemplateEnumConstant()
    {
        return $this->getTemplateContent(
            'enumConstant.txt'
        );
    }

    /**
     * @return string шаблон методы в перечислении
     */
    protected function getTemplateEnumMethod()
    {
        return $this->getTemplateContent(
            'enumMethod.txt'
        );
    }

    /**
     * @param string $commentText текст комментария
     * @return string комменарий к элементу перечисляемого типа
     */
    protected function formatComment($commentText)
    {
        return strlen($commentText) > 0 ? '/** '. $commentText. ' */' : '';
    }

    /**
     * @param string $commentText текст комментария
     * @return string комменарий к элементу перечисляемого типа
     */
    protected function formatCommentClass($commentText)
    {
        return strlen($commentText) > 0 ? ' * '. $commentText : '';
    }


    /**
     * @return string контент сгенерированного класса
     */
    protected function getClassContent()
    {
        $enumConstantList = '';
        $enumMethodList = [];
        foreach($this->getEnumElementList() as $enumElement){
            $enumConstantList .= StringHelper::replacePatterns(
                $this->getTemplateEnumConstant(),
                [
                    '%comment%' => $this->formatComment($enumElement->getComment()),
                    '%name%' => $enumElement->getName(),
                    '%value%' => $enumElement->getValue()
                ]
            );
            $enumMethodList[] = StringHelper::replacePatterns(
                $this->getTemplateEnumMethod(),
                [
                    '%comment%' => $enumElement->getComment(),
                    '%name%' => $enumElement->getName(),
                    '%value%' => $enumElement->getValue()
                ]
            );
        }
        $enumMethodList = implode(PHP_EOL,$enumMethodList);
        return StringHelper::replacePatterns(
            $this->getTemplateEnumClass(),
            [
                '%namespace%' => $this->getEnumNamespace(),
                '%classComment%' => $this->formatCommentClass($this->getClassComment()),
                '%className%' => $this->getClassName(),
                '%classConstants%' => $enumConstantList,
                '%classMethod%' => $enumMethodList
            ]
        );
    }

    /**
     * @return string полный путь к папке с перечислениями
     */
    protected function getEnumDirectoryPath()
    {
        return
            $this->getProjectPath().
            DIRECTORY_SEPARATOR.
            $this->getEnumCodeRelativePath();
    }

    /**
     * @return string полный путь к классу
     */
    protected function getEnumClassPath()
    {
        return
            $this->getEnumDirectoryPath().
            DIRECTORY_SEPARATOR.
            $this->getClassName(). '.php';
    }

    /** Генерация класса перечисления */
    public function generate()
    {
        $enumDirectory = $this->getEnumDirectoryPath();
        if(file_exists($enumDirectory) === false){
            mkdir(
                $enumDirectory,
                0777,
                true
            );
        }
        file_put_contents(
            $this->getEnumClassPath(),
            $this->getClassContent()
        );
    }
}
