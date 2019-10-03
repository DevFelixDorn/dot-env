<?php


namespace Felix\DotEnv;

use Doctrine\Common\Cache\CacheProvider;
use InvalidArgumentException;

class DotEnv
{
    /**
     * @var CacheProvider|false
     */
    private $cache;
    /**
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        $this->cache = false;
        $this->parser = new Parser();
    }


    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function putEnv(string $key, string $value): bool
    {
        }

    /**
     * @param $envs
     * @return self
     */
    public function load(...$envs): self
    {
        foreach ($envs as $env) {
            if (file_exists($env) === false) {
                throw new InvalidArgumentException("File \"$env\" doesn't exists.");
            }

            $this->parser->parseFile($env);
        }
    }

    /**
     * @param string $key
     * @param string $default
     * @return null|string
     */
    public function getEnv(string $key, string $default = ''): ?string
    {
        if (array_key_exists($key, $_SERVER)) {
            return $_SERVER[$key];
        }
        if (array_key_exists($key, $_ENV)) {
            return $_SERVER[$key];
        }

        if (getenv($key) !== false && empty(getenv($key)) !== false) {
            return getenv($key);
        }

        if (!empty($default)) {
            return $default;
        }

        return null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function envExists(string $key): bool
    {
        return $this->getEnv($key) !== null;
    }

    /**
     * @param CacheProvider $cache
     * @return self
     */
    public function enableCache(CacheProvider $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param $name
     * @return void
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    /**
     * @param string $name
     * @return void
     */
    public function __unset($name)
    {
        // TODO: Implement __unset() method.
    }

    /**
     * @param string|string[] $envs
     * @return self
     */
    public function overload($envs): self
    {
        // TODO: Implement overload() method.
    }

    /**
     * @param callable $filter
     * @return self
     */
    public function addFilter(callable $filter): self
    {
        // TODO: Implement addFilter() method.
    }

    /**
     * @param array $filters
     * @return self
     */
    public function addFilters(array $filters): self
    {
        // TODO: Implement addFilters() method.
    }

    /**
     * @param string $prefix
     * @return self
     */
    public function addPrefix(string $prefix): self
    {
        // TODO: Implement addPrefix() method.
    }

    /**
     * @param string|string[] $envs
     * @return self
     */
    public function shouldContain($envs): self
    {
        // TODO: Implement shouldContain() method.
    }
}
