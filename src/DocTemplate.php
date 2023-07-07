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
                $val = self::string_to_array($value);
                if (is_array($val) && count($val)) {
                    $templateProcessor->cloneBlock($key, 0, true, false, $val);
                } else {
                    $find = strpos($val, ';base64,');
                    if ($find !== false) {
                        $templateProcessor->setImageValue($key, $val);
                    } else {
                        $templateProcessor->setValue($key, $val);
                    }
                }
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
                $return[] = ['txt' => strip_tags($t)];
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

    public static function string_to_array($contents)
    {
        $text = [];
        $sp_tmp  = nl2br($contents);
        $sp_tmp = explode("<br />", $sp_tmp);
        if (count($sp_tmp) > 1) {
            foreach ($sp_tmp as $sp) {
                if ($sp) {
                    $text[] = ['txt' => $sp];
                }
            }
        } else {
            $text = $contents;
        }

        return $text;
    }
}
