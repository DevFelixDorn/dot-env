<?php


namespace Felix\DotEnv;


class Parser
{
    public function parseFile($envFile)
    {
        $content = $this->normalizeContent(file_get_contents($envFile));
        dd($content);
    }

    private function normalizeContent($content)
    {
        $lines = explode(PHP_EOL, $content);
        foreach ($lines as $index => $line) {
            if (empty($line)) {
                $this->deleteLine($lines, $index);
                continue;
            }
            if ($this->isComment($line)) {
                $this->deleteLine($lines, $index);
                continue;
            }
            if ($this->notStartingWithChars($line)) {
                throw new \ParseError('Line should not start with something else than a-zA-Z');
            }
        }
        return $lines;

    }

    private function isComment($line)
    {
        return preg_match('/^#([\S+ ]+|)$/', $line);
    }

    private function deleteLine(array &$lines, $index)
    {
        unset($lines[$index]);
    }

    private function notStartingWithChars($line)
    {
        return preg_match('/[a-zA-Z]/', substr($line, 0, 1)) === 1;

    }
}