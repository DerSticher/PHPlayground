<?php

namespace core\Cache;

use core\Util\Singleton;

/**
 * Reads and caches config files.
 *
 * @author Robin Sticher <robin@sticher.info>
 */
class ConfigCache extends Singleton
{
    /**
     * All cached configs.
     * @var array
     */
    private $cachedConfigs = array();

    /**
     * Reads a config file and caches it for further reads.
     * @param  string $configName name of the config file
     * @return array             assoc array config
     */
    public function getConfig($configName)
    {
        if (isset($this->cachedConfigs[$configName])) {
            return $this->cachedConfigs[$configName];
        }

        $configPath = ROOT . 'config' . DS . 'json' . DS;
        $json = null;

        $file = $configPath . $configName . '.json';
        if (is_file($file)) {
            $json = json_decode(file_get_contents($file), true);
            $this->cachedConfigs[$configName] = $json;
            return $json;
        } else {
            throw new \Exception('No such config found', -1);
        }
    }
}
