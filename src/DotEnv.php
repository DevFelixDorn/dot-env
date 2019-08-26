<?php


namespace Felix;

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
     * @return void
     */
    private function parse(): void
    {
        $envs = $this->process();
        foreach ($envs as $key => $value) {
            $value = preg_replace('/"/', '', $value);
            $this->put($key, $value);
        }
    }

    /**
     * @return array
     */
    private function process(): array
    {
        $content = $this->normalizeEnvFile(file_get_contents($this->filename));
        $envs = [];
        $complexEnvs = [];
        foreach (explode(PHP_EOL, $content) as $line) {
            if (!empty($line)) {
                if (!preg_match('/.+=/', $line)) {
                    $line .= '=';
                }
                [$key, $value] = $this->normalizeLine($line);
                if (!preg_match('/\\\\\${.+}/', $value) && preg_match('/\${.+}/', $value)) {
                    $complexEnvs[$key] = $value;
                } else {
                    $envs[$key] = $value;
                }
            }
        }
        foreach ($complexEnvs as $complexEnvKey => $complexEnvValue) {
            foreach ($envs as $key => $value) {
                if (preg_match(sprintf("/\\\${%s}/", $key), $complexEnvValue)) {
                    $complexEnvValue = preg_replace('/\${.+}/', $value, $complexEnvValue);
                    $envs[$complexEnvKey] = $complexEnvValue;
                }
            }
        }

        return $envs;
    }

    /**
     * @param string $content
     * @return string|string[]|null
     */
    private function normalizeEnvFile(string $content)
    {
        $content = preg_replace('/#.+/', '', $content);
        $content = trim($content);
        return $content;
    }

    /**
     * @param $line
     * @return array
     */
    private function normalizeLine($line): array
    {
        $line = explode('=', $line);
        $line[0] = strtoupper($line[0]);
        return $line;
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function put(string $key, string $value): void
    {
        putenv("{$key}={$value}");

        if (isset($_ENV[$key]) && $_ENV[$key] === null) {
            $_ENV[$key] = $value;
        }
        if (isset($_ENV[$key]) && $_SERVER[$key] === null) {
            $_SERVER[$key] = $value;
        }
    }

    /**
     * @param string $filename
     * @return DotEnv
     */
    public function setFilename(string $filename): DotEnv
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return array
     */
    public function parseOnly(): array
    {
        return $this->process();
    }
}
