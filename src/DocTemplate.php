<?php

namespace Ps\DocTemplate;

use PhpOffice\PhpWord\TemplateProcessor;

class DocTemplate
{
    function __construct()
    {
        // 
    }

    public static function save($file, $data = [], $filename = 'ps-word-save.docx')
    {
        $templateProcessor = self::generate($file, $data);
        $templateProcessor->saveAs($filename);
    }

    public static function generate($file, $data = [])
    {
        $templateProcessor = new TemplateProcessor($file);
        foreach ($data as $key => $value) {
            $val = self::clean_text($value);
            if (is_array($val) && count($val) && $key == 'detail') {
                $templateProcessor->cloneBlock($key, 0, true, false, $val);
            } else {
                $templateProcessor->setValue($key, $val);
            }
        }
        return $templateProcessor;
    }

    public static function clean_text($text)
    {
        $tmp = self::count_tag($text);
        if (count($tmp)) {
            $return = [];
            foreach ($tmp as $t) {
                $return[] = ['de' => strip_tags($t)];
            }
            return $return;
        }
        return $text;
    }

    public static function count_tag($contents)
    {
        preg_match_all("#<p[^>]*>(.*?)</p>#i", $contents, $matches);
        return $matches[1];
    }
}
