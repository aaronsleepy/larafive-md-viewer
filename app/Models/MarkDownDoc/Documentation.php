<?php

namespace App\Models\MarkDownDoc;

use Illuminate\Support\Facades\File;

class Documentation
{
    /**
     * 마크다운 파일 확장자.
     *
     * @var string
     */
    private const FILE_EXTENSION = '.md';

    /**
     * 마크다운 파일을 읽어서 본문을 리턴한다.
     *
     * @param string $file
     * @return string
     */
    public function get(string $file = 'documentation.md') : string
    {
        $content = File::get($this->path($file));
        return $this->replaceLinks($content);
    }

    /**
     * 파일 경로를 표준 파일 경로로 변환해서 리턴한다.
     *
     * @param string $file
     * @return string
     */
    private function path(string $file): string
    {
        $file = ends_with($file, Documentation::FILE_EXTENSION) ? $file : $file . Documentation::FILE_EXTENSION;
        $path = base_path('docs' . DIRECTORY_SEPARATOR . $file);

        if (! File::exists($path)) {
            abort(404, "Requested ${file} does not exists!");
        }
        return $path;
    }

    /**
     * 다운로드한 예제 마크다운 파일에는 {{version}} 표시자가 불필요하므로 제거한다.
     *
     * @param string $content
     * @return string
     */
    private function replaceLinks(string $content): string
    {
        return str_replace('/docs/{{version}}', '/docs/', $content);
    }
}
