<?php
/**
 * markdown 문자열을 받아서 wiki 포맷으로 파싱하여 리턴한다.
 * @param string|null $text
 * @return mixed
 */
if (! function_exists('markdown')) {
    function markdown(string $text = null)
    {
        return app(ParsedownExtra::class)->text($text);
    }

}
