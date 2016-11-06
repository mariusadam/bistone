<?php

namespace Contest\IO;

use Exception;
use Generator;

class FileReader
{
    /**
     * @var string
     */
    private $filename;

    /**
     * FileReader constructor.
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return Generator
     * @throws Exception
     */
    public function getLines()
    {
        if (!file_exists($this->filename)) {
            throw new Exception(sprintf('Could not find file \'%s\'.', $this->filename));
        }

        $handle = fopen($this->filename, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                yield trim($line);
            }

            fclose($handle);
        } else {
            throw new Exception(sprintf('Could not open file \'%s\'.', $this->filename));
        }
    }

}