<?php

declare(strict_types=1);

namespace Loom\Util\ArrayUtil;

final class MergeReplaceKey implements MergeReplaceKeyInterface
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
