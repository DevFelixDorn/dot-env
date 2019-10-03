<?php


namespace Felix;


use Doctrine\Common\Cache\CacheProvider;

interface DotEnvApi extends \ArrayAccess
{
    /**
     * @param string $file
     * @return array
     */
    public function parseFile(string $file): array;

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function putEnv(string $key, string $value): bool;

    /**
     * @param $envs
     * @return self
     */
    public function load($envs): self;

    /**
     * @param string $key
     * @return self
     */
    public function getEnv(string $key): self;

    /**
     * @param string $key
     * @return bool
     */
    public function envExists(string $key): bool;

    /**
     * @param CacheProvider $cache
     * @return self
     */
    public function enableCache(CacheProvider $cache): self;

    /**
     * @param $name
     * @return void
     */
    public function __get($name);

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value);

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name);

    /**
     * @param string $name
     * @return void
     */
    public function __unset($name);

    /**
     * @param string|string[] $envs
     * @return self
     */
    public function overload($envs): self;

    /**
     * @param callable $filter
     * @return self
     */
    public function addFilter(callable $filter): self;

    /**
     * @param array $filters
     * @return self
     */
    public function addFilters(array $filters): self;

    /**
     * @param string $prefix
     * @return self
     */
    public function addPrefix(string $prefix): self;

    /**
     * @param string|string[] $envs
     * @return self
     */
    public function shouldContain($envs): self;
}