<?php

namespace Da\ApiServerBundle\Doctrine\MongoDB\Decorator;

use Da\ApiServerBundle\Doctrine\MongoDB\AbstractQueryBuilderDecorator;

/**
 * Lower than operation decorator.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class LowerThan extends AbstractQueryBuilderDecorator
{
    /**
     * {@inheritdoc}
     */
    protected function handle($operation)
    {
        return ($operation === '<');
    }

    /**
     * {@inheritdoc}
     */
    protected function check(array $arguments)
    {
        $argumentsCount = count($arguments);

        if ($argumentsCount < 1) {
            throw new \InvalidArgumentException('The "lower than" method take one argument.');
        } else if ($argumentsCount > 1) {
            throw new \InvalidArgumentException('Too many arguments for a "lower than" operation.');
        }

        return $arguments;
    }

    /**
     * {@inheritdoc}
     */
    protected function interpret(array $arguments, $field)
    {
        return $this->createChunk($field)->lt($arguments[0]);
    }
}