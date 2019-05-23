<?php
/**
 * @see       https://github.com/phly/keep-a-changelog for the canonical source repository
 * @copyright Copyright (c) 2019 Matthew Weier O'Phinney
 * @license   https://github.com/phly/keep-a-changelog/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Phly\KeepAChangelog\Entry;

use TypeError;
use UnexpectedValueException;

class InjectionIndex
{
    public const ACTION_INJECT = 'inject';
    public const ACTION_REPLACE = 'replace';
    public const ACTION_NOT_FOUND = 'not-found';

    private const ACTIONS = [
        self::ACTION_INJECT,
        self::ACTION_REPLACE,
        self::ACTION_NOT_FOUND,
    ];

    /** @var null|int */
    private $index = null;

    /** @var string */
    private $type = self::ACTION_NOT_FOUND;

    public function __get(string $name)
    {
        switch ($name) {
            case 'index':
                return $this->index;
            case 'type':
                return $this->type;
            default:
                throw new UnexpectedValueException(sprintf(
                    'The property "%s" does not exist for class "%s"',
                    $name,
                    gettype($this)
                ));
        }
    }

    public function __set(string $name, $value)
    {
        switch ($name) {
            case 'index':
                if (! is_int($value)) {
                    throw new TypeError(sprintf(
                        'Property %s expects an integer; received %s',
                        $name,
                        gettype($value)
                    ));
                }
                $this->$name = $value;
                break;
            case 'type':
                if (! in_array($value, self::ACTIONS, true)) {
                    throw new TypeError(sprintf(
                        'Property %s expects one of the constants ACTION_INJECT, ACTION_REPLACE, or ACTION_NOT_FOUND',
                        $name
                    ));
                }
                $this->$name = $value;
                break;
            default:
                throw new UnexpectedValueException(sprintf(
                    'The property "%s" does not exist for class "%s"',
                    $name,
                    gettype($this)
                ));
        }
    }
}