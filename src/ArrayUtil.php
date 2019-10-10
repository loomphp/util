<?php

declare(strict_types=1);

namespace Loom\Util;

abstract class ArrayUtil
{

    /**
     * Perform a recursive merge of two multi-dimensional arrays.
     *
     * @param array $a
     * @param array $b
     * @return array
     */
    public static function mergeArray(array $a, array $b): array
    {
        foreach ($b as $key => $value) {
            if ($value instanceof ArrayUtil\MergeReplaceKeyInterface) {
                $a[$key] = $value->getData();
            } elseif (isset($a[$key]) || array_key_exists($key, $a)) {
                if ($value instanceof ArrayUtil\MergeRemoveKey) {
                    unset($a[$key]);
                } elseif (is_int($key)) {
                    $a[] = $value;
                } elseif (is_array($value) && is_array($a[$key])) {
                    $a[$key] = static::mergeArray($a[$key], $value);
                } else {
                    $a[$key] = $value;
                }
            } else {
                if (! $value instanceof ArrayUtil\MergeRemoveKey) {
                    $a[$key] = $value;
                }
            }
        }
        return $a;
    }
}
