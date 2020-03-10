<?php

declare(strict_types=1);

namespace App\Bundles;

use Doctrine\ORM\Mapping\DefaultNamingStrategy;
use function strtolower;
use function ucfirst;

class CamelCaseNamingStrategy extends DefaultNamingStrategy
{
    private const DEFAULT_PATTERN = '/(?<=[a-z])([A-Z])/';

    /**
     * {@inheritdoc}
     */
    public function embeddedFieldToColumnName(
        $propertyName,
        $embeddedColumnName,
        $className = null,
        $embeddedClassName = null
    ): string
    {
        return $propertyName . ucfirst($embeddedColumnName);
    }

    /**
     * {@inheritdoc}
     */
    public function joinColumnName($propertyName, $className = null): string
    {
        return $propertyName . ucfirst($this->referenceColumnName());
    }

    /**
     * {@inheritdoc}
     */
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null): string
    {
        return strtolower($this->classToTableName($sourceEntity) . ucfirst($this->classToTableName($targetEntity)));
    }

    /**
     * {@inheritdoc}
     */
    public function classToTableName($className)
    {
        if (strpos($className, '\\') !== false) {
            $className = substr($className, strrpos($className, '\\') + 1);
        }

        return $this->underscore($className);
    }

    private function underscore(string $string): string
    {
        $string = preg_replace(self::DEFAULT_PATTERN, '_$1', $string);

        return strtolower($string);
    }

    /**
     * {@inheritdoc}
     */
    public function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        if (null === $referencedColumnName) {
            $referencedColumnName = $this->referenceColumnName();
        }

        return $this->classToTableName($entityName) . ucfirst($referencedColumnName);
    }
}