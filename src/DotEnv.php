<?php


namespace Felix;


use RuntimeException;

class DotEnv
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $filename
     */
    public static function register(string $filename): void
    {

        (new self)->setFilename($filename)->parse();
    }

    /**
     *
     */
    private function parse(): void
    {
        $content = $this->normalizeEnvFile(file_get_contents($this->filename));
        $envs = [];
        $complexEnvs = [];
        foreach (explode(PHP_EOL, $content) as $line) {
            [$key, $value] = $this->normalizeLine($line);
            if (!preg_match('/\\\\\${.+}/', $value) && preg_match('/\${.+}/', $value)) {
                $complexEnvs[$key] = $value;
            } else {
                $envs[$key] = $value;
            }
        }
        foreach ($complexEnvs as $complexEnvKey => $complexEnvValue) {
            foreach ($envs as $key => $value) {
                if (preg_match(sprintf('/\${%s}/', $key), $complexEnvValue)) {
                    $complexEnvValue = preg_replace('/\${.+}/', $value, $complexEnvValue);
                    $envs[$complexEnvKey] = $complexEnvValue;
                }
            }
        }
        foreach ($envs as $key => $value) {
            $this->put($key, $value);
        }
    }

    private function normalizeEnvFile(string $content)
    {
        $content = preg_replace('/\#.+/', '', $content);
        $content = preg_replace('/"/m', '', $content);
        $content = trim($content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = preg_replace('/ /', PHP_EOL, $content);
        return $content;
    }

    private function normalizeLine($line): array
    {
        $line = explode('=', $line);
        $line[0] = strtoupper($line[0]);
        return $line;
    }

    private function put(string $key, string $value): void
    {
        putenv("{$key}={$value}");

        if ($_ENV[$key] === null) {
            $_ENV[$key] = $value;
        }
        if ($_SERVER[$key] === null) {
            $_SERVER[$key] = $value;
        }
    }

    /**
     * @param string $filename
     * @return DotEnv
     */
    public
    function setFilename(string $filename): DotEnv
    {
        $this->filename = $filename;
        return $this;
    }
}