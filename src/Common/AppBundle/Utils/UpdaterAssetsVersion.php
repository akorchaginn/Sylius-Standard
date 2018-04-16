<?php
/**
 * Description of UpdaterAssetsVersion

 */

namespace Common\AppBundle\Utils;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;


class UpdaterAssetsVersion {
    const ASSETS_VERSION = 'assets_version';

    public static function updateAssetsVersion()
    {           
        $yaml_file_name = self::getYamlFileName();
        
        if (is_writable($yaml_file_name)) {
            try {
                $parameters = Yaml::parse(file_get_contents($yaml_file_name));
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }

            $assets = self::generateAssetsVersion();
            
            $parameters["parameters"][self::ASSETS_VERSION] = $assets;
            
            $yaml = Yaml::dump($parameters);

            file_put_contents($yaml_file_name, $yaml);
            
            return $assets;
        }
        else {
            return 'File not found or permission denied!';
        }
        
    }
    
    /**
     *
     * @return string|null
     */
    protected function generateAssetsVersion()
    {
            return substr(md5(date('c')), 0, 10);
    }

    /**
     *
     * @return string
     */
    protected function getYamlFileName()
    {
        return 'app/config/parameters.yml';
    }

}
