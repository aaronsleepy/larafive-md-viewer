<?php

namespace App\Http\Controllers;

use App\Models\MarkDownDoc\Documentation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;

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
        $index = markdown($this->documentation->get());
        $content = markdown($this->documentation->get($file));
        return compact('index', 'content');
    }

    /**
     * 마크다운 파일 뷰를 리턴한다
     *
     * @param string $file
     * @return Factory|Application|View
     */
    public function showView(string $file = 'installation.md')
    {
        $index = markdown($this->documentation->get());
        $content = markdown($this->documentation->get($file));
        return view('docs.show', compact('index', 'content'));
    }
}
