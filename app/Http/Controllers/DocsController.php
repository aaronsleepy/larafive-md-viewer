<?php

namespace App\Http\Controllers;

use App\Models\MarkDownDoc\Documentation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Symfony\Component\Console\Output\ConsoleOutput;

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
        $index = Cache::remember('docs.index', 120, function () {
            return markdown($this->documentation->get());
        });
        $content = Cache::remember("docs.{$file}", 120, function () use ($file) {
            return markdown($this->documentation->get($file));
        });
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
        $index = Cache::remember('docs.index', 120, function () {
            return markdown($this->documentation->get());
        });
        $content = Cache::remember("docs.{$file}", 120, function () use ($file) {
            return markdown($this->documentation->get($file));
        });
        return view('docs.show', compact('index', 'content'));
    }

    public function image(String $file)
    {
        (new ConsoleOutput())->writeln("$file");
        $image = $this->documentation->image($file);

        return response($image->encode('png'), 200, [
           'Content-Type' => 'image/png'
        ]);
    }
}
