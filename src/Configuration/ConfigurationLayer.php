<?php

declare(strict_types=1);

namespace SensioLabs\Deptrac\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

final class ConfigurationLayer
{
    /** @var ConfigurationCollector[] */
    private $collectors;

    private $name;

    /**
     * @param array<string, mixed> $args
     */
    public static function fromArray(array $args): self
    {
        $options = (new OptionsResolver())->setRequired([
            'name',
            'collectors',
        ])->resolve($args);

        return new static(
            array_map(static fn ($v) => ConfigurationCollector::fromArray($v), $options['collectors']),
            $options['name']
        );
    }

    /**
     * @param ConfigurationCollector[] $collectors
     */
    private function __construct(array $collectors, string $name)
    {
        $this->collectors = $collectors;
        $this->name = $name;
    }

    /**
     * @return ConfigurationCollector[]
     */
    public function getCollectors(): array
    {
        return $this->collectors;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
