<?php

namespace App\Http\Controllers;

use App\Models\MarkDownDoc\Documentation;

class DocsController extends Controller
{
    private $documentation;

    /**
     * @param Documentation $documentation
     */
    public function __construct(Documentation $documentation)
    {
        $this->documentation = $documentation;
    }

    /**
     * 마크다운 파일을 받아서 index 정보와 content 정보를 리턴한다.
     *
     * @param string $file
     * @return array
     */
    public function show(string $file = 'installation.md'): array
    {
        $index = markdown($this->documentation->get($file));
        $content = markdown($this->documentation->get($file));
        return compact('index', 'content');
    }


}
