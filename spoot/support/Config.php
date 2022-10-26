<?php

namespace Spoot\Support;

use Spoot\Application;

class Config
{
    private array $loaded = [];

    public function get(string $key, mixed $default = null): mixed
    {
        $segments = explode(".", $key);
        $file = array_shift($segments);



        if (!isset($this->loaded[$file])) {
            $base = Application::GetInstance()->resolve("path.base");
            $sep = DIRECTORY_SEPARATOR;

            $this->loaded[$file] = (array) require "{$base}{$sep}config{$sep}{$file}.php";
        }


        if ($value = $this->WithDots($this->loaded[$file], $segments)) {
            return $value;
        }

        return $default;
    }

    private function WithDots(array $array, array $segments): mixed
    {
        $current = $array;

        foreach ($segments as $item) {
            if (!isset($current[$item])) {
                return null;
            }

            $current = $current[$item];
        }
        return $current;
    }
}
