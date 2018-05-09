<?php

namespace PoTranslate;


class TwigToPo
{

    private $translates = [];

    public function parse($twig_files_path)
    {
        $files = $this->rsearch($twig_files_path, '/.*\.twig/');

        $re = '@e\([\"|\']{1}(.*)[\"|\']{1}\)@m';

        foreach ($files as $file) {
            $txt = file_get_contents($file);

            preg_match_all($re, $txt, $matches);
            if (!empty($matches[1])) {
                $this->translates = array_merge($this->translates, $matches[1]);
            }
        }
    }

    public function addTranslates(array $translates)
    {
        $this->translates = array_merge($this->translates, $translates);
    }

    public function addTranslate(string $translate)
    {
        $this->addTranslates((array)$translate);
    }

    private function rsearch($folder, $pattern)
    {
        $dir = new \RecursiveDirectoryIterator($folder);
        $ite = new \RecursiveIteratorIterator($dir);
        $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
        $fileList = array();
        foreach ($files as $file) {
            $fileList = array_merge($fileList, $file);
        }
        return $fileList;
    }

    public function save($output_file)
    {
        $this->translates = array_unique($this->translates);

        $php = "<?php\n";
        foreach ($this->translates as $translate) {
            $php .= "_e('$translate');\n";
        }

        file_put_contents($output_file, $php);
    }

}