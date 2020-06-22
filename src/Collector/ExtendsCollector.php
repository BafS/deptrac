<?php

declare(strict_types=1);

namespace SensioLabs\Deptrac\Collector;

use SensioLabs\Deptrac\AstRunner\AstMap;
use SensioLabs\Deptrac\AstRunner\AstMap\AstClassReference;

class ExtendsCollector implements CollectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'extends';
    }

    /**
     * {@inheritdoc}
     */
    public function satisfy(
        array $configuration,
        AstClassReference $astClassReference,
        AstMap $astMap,
        Registry $collectorRegistry
    ): bool {
        $interfaceName = $this->getInterfaceName($configuration);

        foreach ($astMap->getClassInherits($astClassReference->getClassLikeName()) as $inherit) {
            if ($inherit->isExtends() && $inherit->getClassLikeName()->equals($interfaceName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string, string> $configuration
     */
    private function getInterfaceName(array $configuration): AstMap\ClassLikeName
    {
        if (!isset($configuration['extends'])) {
            throw new \LogicException('ExtendsCollector needs the interface or class name as a string.');
        }

        return AstMap\ClassLikeName::fromFQCN((string) $configuration['extends']);
    }
}
