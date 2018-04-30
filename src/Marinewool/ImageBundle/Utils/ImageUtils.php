<?php

/**
 * Description of ImageUtils
 *
 * @author akorchagin
 */

namespace Marinewool\ImageBundle\Utils;

class ImageUtils {
    
    /**
     * @var Array of string
     */
    private $files = array();
    

    public function fetchFiles($path)
    {   
        $files = scandir($path);
  
        unset($files[1]);
        unset($files[0]);
        foreach ($files as &$file) {
            if (!is_file($path . '/' . $file)) {
                $file = $this->fetchFiles($path . '/' . $file);
            } else {
                $full_path = explode('/', $path);
                array_push($this->files, $full_path[3] . '/' . $full_path[4] . '/' . $file);
            }
        }
        return $this->files;
    }
}
