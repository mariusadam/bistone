<?php

namespace Contest\IO;

class FileWriter
{
    /**
     * @var resource
     */
    private $handle;

    /**
     * FileWriter constructor.
     * @param string $filename
     * @param string $mode
     * @throws Exception
     */
    public function __construct($filename, $mode = 'w')
    {
        $this->handle = fopen($filename, $mode);
    }

    /**
     * @param $format
     * @param null $args
     * @param null $_
     * @return int
     */
    public function writeFormatted($format, $args = null, $_ = null)
    {
        return fprintf($this->handle, $format, $args, $_);
    }

    /**
     * @param $format
     * @param null $args
     * @param null $_
     * @return int
     */
    public function writelnFormatted($format, $args = null, $_ = null)
    {
        $wrote = $this->writeFormatted($format, $args, $_);
        $wrote += $this->writeln();

        return $wrote;
    }

    public function writeln()
    {
        return $this->writeFormatted("%s", "\n");
    }

    /**
     * @param int $int
     * @return int
     */
    public function writeInt($int)
    {
        return $this->writeFormatted("%d", $int);
    }

    /**
     * @param $string
     * @return int
     */
    public function writeString($string)
    {
        return $this->writeFormatted("%s", $string);
    }

    /**
     * @return bool
     */
    public function close()
    {
        return fclose($this->handle);
    }
}