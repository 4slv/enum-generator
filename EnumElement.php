<?php

namespace EnumGenerator;

/** Элемент перечисляемого типа */
class EnumElement
{
    /**
     * @var string название
     */
    protected $name;

    /**
     * @var string значение
     */
    protected $value;

    /**
     * @var string комментарий
     */
    protected $comment;

    /**
     * @return string название
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name название
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string значение
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value значение
     * @return $this
     */
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string комментарий
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment комментарий
     * @return $this
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
        return $this;
    }


}
