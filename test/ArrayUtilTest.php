<?php

declare(strict_types=1);

namespace LoomTest\Util;

use Loom\Util\ArrayUtil;
use PHPUnit\Framework\TestCase;

class ArrayUtilTest extends TestCase
{
    public static function mergeArrays()
    {
        return [
            'merge-integer-and-string keys' => [
                [
                    'foo',
                    3 => 'bar',
                    'baz' => 'baz'
                ],
                [
                    'baz',
                ],
                [
                    0     => 'foo',
                    3     => 'bar',
                    'baz' => 'baz',
                    4     => 'baz'
                ]
            ],
            'merge-arrays-recursively' => [
                [
                    'foo' => [
                        'baz'
                    ]
                ],
                [
                    'foo' => [
                        'baz'
                    ]
                ],
                [
                    'foo' => [
                        0 => 'baz',
                        1 => 'baz'
                    ]
                ]
            ],
            'replace-string-keys' => [
                [
                    'foo' => 'bar',
                    'bar' => []
                ],
                [
                    'foo' => 'baz',
                    'bar' => 'bat'
                ],
                [
                    'foo' => 'baz',
                    'bar' => 'bat'
                ]
            ],
        ];
    }

    /**
     * @dataProvider mergeArrays
     */
    public function testMerge($a, $b, $expected)
    {
        $this->assertEquals($expected, ArrayUtil::mergeArray($a, $b));
    }

    public function testMergeReplaceKey()
    {
        $expected = [
            'car' => [
                'met' => 'bet',
            ],
            'new' => [
                'foo' => 'get',
            ],
        ];
        $a = [
            'car' => [
                'boo' => 'foo',
                'doo' => 'moo',
            ],
        ];
        $b = [
            'car' => new ArrayUtil\MergeReplaceKey([
                'met' => 'bet',
            ]),
            'new' => new ArrayUtil\MergeReplaceKey([
                'foo' => 'get',
            ]),
        ];
        $this->assertInstanceOf('Loom\Util\ArrayUtil\MergeReplaceKeyInterface', $b['car']);
        $this->assertEquals($expected, ArrayUtil::mergeArray($a, $b));
    }

    /**
     * @group 6899
     */
    public function testAllowsRemovingKeys()
    {
        $a = [
            'foo' => 'bar',
            'bar' => 'bat'
        ];
        $b = [
            'foo' => new ArrayUtil\MergeRemoveKey(),
            'baz' => new ArrayUtil\MergeRemoveKey(),
        ];
        $expected = [
            'bar' => 'bat'
        ];
        $this->assertEquals($expected, ArrayUtil::mergeArray($a, $b));
    }
}
