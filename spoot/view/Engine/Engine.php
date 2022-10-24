<?php

namespace Spoot\View\Engine;

use Spoot\View\View;

interface Engine
{
    public function render(View $view);
}
