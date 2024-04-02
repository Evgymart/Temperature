<?php

namespace Alignant\Temperature;

use Symfony\Component\HttpFoundation\Request;

class App
{
    public function run(): void
    {
        $request = Request::createFromGlobals();
        print_r($request->getSchemeAndHttpHost());
    }

}