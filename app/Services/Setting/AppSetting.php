<?php 

namespace App\Services\Setting;

use SettingRepository;
use App\Services\Setting\Cache;

/**
 * Class Setting
 * 
 */
class AppSetting
{
    protected $repo;

    protected $cache;

    public function __construct(SettingRepository $repo, Cache $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Gets a value
     *
     * @param  string $key
     * @param  string $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = $this->fetch($key);

        if(!is_null($value))
            return $value;
        else if($default != null)
            return $default;
        else
            return $default;
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    private function fetch($key)
    {

        if ($this->cache->hasKey($key)) {
            return $this->cache->get($key);
        }

        $row = $this->repo->where('key', $key)->first(['value']);

        return (!is_null($row)) ? $this->cache->set($key, $row->value) : null;
    }


    /**
     * Checks if setting exists
     *
     * @param $key
     *
     * @return bool
     */
    public function hasKey($key)
    {
        if ($this->cache->hasKey($key)) {
            return true;
        }
        $row = $this->repo->where('key', $key)->first(['value']);

        return (count($row) > 0);
    }

    /**
     * Store value into registry
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        // $value = serialize($value);

        $setting = $this->repo->where('key', $key)->first();

        if (is_null($setting)) {
            $this->repo->model()->insert(['key' => $key, 'value' => $value]);
        } else {
            $this->repo->where('key', $key)
                           ->update(['value' => $value]);
        }

        $this->cache->set($key, $value);

        return $value;
    }


    /**
     * Remove a setting
     *
     * @param  string $key
     *
     * @return void
     */
    public function forget($key)
    {
        $this->repo->where('key', $key)->delete();
        $this->cache->forget($key);
    }

    /**
     * Remove all settings
     *
     * @return bool
     */
    public function flush()
    {
        $this->cache->flush();

        return $this->repo->delete();
    }

    /**
     * Fetch all values
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->cache->getAll();
    }

    
}