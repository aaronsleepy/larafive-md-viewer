<?php

namespace App\Models\MarkDownDoc;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Documentation
{
    /**
     * 마크다운 파일 확장자.
     *
     * @var string
     */
    private const FILE_EXTENSION = '.md';

    private const IMAGE_FILE_EXTENSION = '.png';

    /**
     * 마크다운 파일을 읽어서 본문을 리턴한다.
     *
     * @param string $file
     * @return string
     */
    public function get(string $file = 'documentation.md') : string
    {
        $content = File::get($this->path('docs', $file, self::FILE_EXTENSION));
        return $this->replaceLinks($content);
    }

    /**
     * 이미지 파일을 읽어서 리턴한다.
     *
     * @param string $file
     * @return \Intervention\Image\Image
     */
    public function image(string $file): \Intervention\Image\Image
    {
        return Image::make($this->path('docs/images', $file, self::IMAGE_FILE_EXTENSION));
    }

    /**
     * 파일 경로를 표준 파일 경로로 변환해서 리턴한다.
     *
     * @param string $file
     * @return string
     */
    private function path(string $dir, string $file, string $fileExtension): string
    {
        $file = ends_with($file, $fileExtension) ? $file : $file . $fileExtension;
        $path = base_path($dir . DIRECTORY_SEPARATOR . $file);

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
