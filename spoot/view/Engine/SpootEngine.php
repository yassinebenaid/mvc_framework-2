<?php

namespace Spoot\View\Engine;

use Spoot\View\Manager;
use Spoot\View\View;

class SpootEngine implements Engine
{
    private  array $layouts = [];
    private Manager $manager;


    public function render(View $view)
    {
        $path =  $view->path;
        $data = $view->data;

        $hash = md5($path);
        $casheFolder = realpath(Root() . "/spoot/storage/view");

        $cashedFile = "$casheFolder\\{$hash}.php";

        $contents = file_get_contents($path);


        if (!file_exists($cashedFile) || filemtime($cashedFile) < filemtime($path)) {
            $contents = $this->compile($contents);
            file_put_contents($cashedFile, $contents);
        }

        extract($data);
        ob_start();
        require $cashedFile;
        $contents = ob_get_contents();
        ob_end_clean();


        if ($layout = $this->layouts[$cashedFile] ?? null) {
            $contents = view($layout["layout"], [$layout['placeholder'] => $contents, ...$data]);
        }

        return $contents;
    }

    private function compile(string $template): string
    {

        // {{var}}
        $template = preg_replace_callback(
            "#\{\{([^}}]+)}}#",
            function ($matches) {
                return '<?php print ' . $matches[1] . ' ?>';
            },
            $template
        );

        // @for
        $template = preg_replace_callback(
            "#@for\s([\sa-zA-Z_]+)\sin\s([^:]+)\:#",
            function ($matches) {
                return '<?php for($' . trim($matches[1]) . ' = 0; $' . trim($matches[1]) . ' < ' . trim($matches[2]) . '; $' . trim($matches[1]) . '++) : ?>';
            },
            $template
        );

        // @if and @elseif
        $template = preg_replace_callback(
            "#(@if|@elseif)([^:]+)\:#",
            function ($matches) {
                if ($matches[1] === "@if") return '<?php if(' . trim($matches[2],) . '): ?>';
                else return '<?php elseif(' . trim($matches[2],) . '): ?>';
            },
            $template
        );

        // @else
        $template = preg_replace_callback(
            "#@else#",
            function ($matches) {
                return '<?php else: ?>';
            },
            $template
        );

        // @foreach
        $template = preg_replace_callback(
            "#@foreach\s([\w$]+)\sas\s([^:]+)\:#",
            function ($matches) {
                return '<?php foreach(' . trim($matches[1]) . ' as ' . trim($matches[2]) . ') : ?>';
            },
            $template
        );

        // @endforeach
        $template = preg_replace_callback(
            "#@end([a-z]+)#",
            function ($matches) {
                if ($matches[1] === "foreach") return '<?php endforeach; ?>';
                elseif ($matches[1] === "if") return '<?php endif; ?>';
                elseif ($matches[1] === "for") return '<?php endfor; ?>';
            },
            $template
        );

        // @extend
        $template = preg_replace_callback(
            "#@extends\s([\s]*[a-zA-Z_\.\"\']+[\s]*)\sfrom\s([\s\n\t\r]*[^:\s\n\t\r]+[\s\n\t\r]*)\:#",
            function ($matches) {
                $matches = array_map(fn ($el) => str_replace(['"', "'"], "", $el), $matches);
                return '<?php $this->extends("' . trim($matches[1]) . '", "' . trim($matches[2]) . '") ;?>';
            },
            $template
        );

        // @assingments
        $template = preg_replace_callback(
            "#@\{([^}]+)}#",
            function ($matches) {
                return '<?php ' . $matches[1] . ' ?>';
            },
            $template
        );


        // @function
        $template = preg_replace_callback(
            "#@([a-zA-Z0-9_]+)\(([^)]+)\)#",
            function ($matches) {
                return '$this->' . trim($matches[1]) . '(' . trim($matches[2]) . ') ';
            },
            $template
        );


        return $template ?? "";
    }

    public function extends(string $layout, string $placeholder)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $this->layouts[$backtrace[0]["file"]]["layout"] = $layout;
        $this->layouts[$backtrace[0]["file"]]["placeholder"] = $placeholder;
    }

    public function setManager(Manager $manager): static
    {
        $this->manager = $manager;
        return $this;
    }

    public function __call($name, $arguments)
    {
        return $this->manager->useMacro($name, ...$arguments);
    }
}
// \: