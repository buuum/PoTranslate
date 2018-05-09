<?php

namespace PoTranslate;

use Sepia\PoParser\Catalog\Catalog;
use Sepia\PoParser\Parser;
use Sepia\PoParser\SourceHandler\FileSystem;

class Translate
{

    /**
     * @var Catalog
     */
    private $catalog;

    public function __construct(string $path_to_file)
    {
        try {
            $fileHandler = new FileSystem($path_to_file);
            $poParser = new Parser($fileHandler);
            $this->catalog = $poParser->parse();
        } catch (\Exception $e) {
            $this->catalog = null;
        }

        $GLOBALS['_translate_from_catalog'] = [$this, 'translate'];
    }

    public function translate($name)
    {
        if (!$this->catalog) {
            return $name;
        }

        if ($entry = $this->catalog->getEntry($name)) {
            return !empty($entry->getMsgStr()) ? $entry->getMsgStr() : $name;
        }

        return $name;
    }
}