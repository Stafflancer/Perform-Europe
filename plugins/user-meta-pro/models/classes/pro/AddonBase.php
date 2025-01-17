<?php
namespace UserMeta;

/**
 * Base class for loading the addons.
 *
 * @author Khaled Hossain
 * @since 1.4
 */
class AddonBase
{
    /**
     * Plugin namespace
     */
    protected static $namespace = __NAMESPACE__;

    /**
     * an array to hold addon's data.
     */
    protected static $addonData = [];

    /**
     * Maps array to store key => value.
     */
    private static $maps = [];

    /**
     * Populate $addonData.
     * This method should called by plugin's main file right before loading controllers.
     *
     * @param
     *            string __FILE__ : Path of the plugin main file
     */
    public static function init($filePath)
    {
        static::$addonData['file'] = $filePath;
        static::$addonData['path'] = dirname($filePath);
        static::$addonData['url'] = plugins_url('', $filePath);
        static::$addonData['name'] = basename($filePath, '.php');
    }

    /**
     * Get plugin's Data.
     *
     * @param string $key:
     *            name, version, file, slug, path, url
     *
     * @return [array|string] array when $key is null otherwise string
     */
    public static function addonData($key = null)
    {
        if (! empty($key))
            return isset(static::$addonData[$key]) ? static::$addonData[$key] : '';

        return static::$addonData;
    }

    /**
     * Get maps.
     *
     * @param string $key:
     *
     * @return [array|string] array when $key is null otherwise string
     */
    public static function maps($key = null)
    {
        if (! empty($key))
            return isset(static::$maps[$key]) ? static::$maps[$key] : '';

        return static::$maps;
    }

    /**
     * Get addon name
     *
     * @return string
     */
    public static function name()
    {
        return static::addonData('name');
    }

    /**
     * Get stored addon data
     *
     * @return mixed
     */
    public static function getData()
    {
        global $userMeta;
        return $userMeta->getData('addon_' . static::name());
    }

    /**
     * Store addon data
     *
     * @param mixed $data
     * @return boolean
     */
    public static function updateData($data)
    {
        global $userMeta;
        return $userMeta->updateData('addon_' . static::name(), $userMeta->arrayRemoveEmptyValue($data));
    }

    /**
     * Get base directory of the plugin.
     *
     * @return string
     */
    public static function basePath($path = null)
    {
        return static::addonData('path') . $path;
    }

    /**
     * Get base url of the plugin.
     *
     * @return string
     */
    public static function baseUrl($path = null)
    {
        return static::addonData('url') . $path;
    }

    /**
     * Get path of resources directory.
     *
     * @return string
     */
    public static function resourcePath($path = null)
    {
        return static::basePath() . '/resources' . $path;
    }

    /**
     * Get resources url.
     *
     * @return string
     */
    public static function resourceUrl($path = null)
    {
        return static::baseUrl() . '/resources' . $path;
    }

    /**
     * Get list of files from a directory.
     *
     * @param string $directory
     *            full path of the directory
     * @param string $filter
     *            Filter return list (e.g: php)
     *
     * @return array
     */
    public static function getFilesList($directory, $filter = null)
    {
        $files = [];
        if (file_exists($directory)) {
            foreach (scandir($directory) as $item) {
                if ((in_array($item, [
                    '.',
                    '..'
                ])) || ($filter && ! preg_match("/\.$filter$/i", $item))) {
                    continue;
                }
                $files[] = $item;
            }
        }

        return $files;
    }

    /**
     * make instance of each controller class.
     */
    public static function loadControllers()
    {
        $files = static::getFilesList(static::basePath() . '/controllers', 'php');
        foreach ($files as $file) {
            if (strpos($file, 'Controller.php') !== false) {
                require_once static::basePath() . '/controllers/' . $file;
                $class = static::$namespace . '\\' . rtrim($file, '.php');
                new $class();
            }
        }
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string $view
     *            allows subdirectory as . or / notation
     * @param array $data
     * @param array $mergeData
     *
     * @return string
     */
    public static function view($view = null, $data = [])
    {
        $path = static::basePath() . '/resources/views';
        $path .= '/' . str_replace('.', '/', $view) . '.php';
        if ($data)
            extract($data);

        ob_start();
        include $path;
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * Enque javascript or css file.
     *
     * @param string $subdir
     *            (optionl)
     * @param string $filename
     *            Filename with extension
     * @param string $handle
     */
    public static function enqueScript($filename, $subdir = null, $handle = null)
    {
        global $userMeta;
        $file = pathinfo($filename);
        $handle = ! empty($handle) ? $handle : $file['filename'];
        $partialPath = ! empty($subdir) ? $subdir . '/' : '';
        $partialPath .= $filename;
        if ($file['extension'] == 'js') {
            wp_enqueue_script($handle, static::resourceUrl() . '/js/' . $partialPath, [
                'jquery'
            ], $userMeta->version, true);
        } elseif ($file['extension'] == 'css') {
            wp_enqueue_style($handle, static::resourceUrl() . '/css/' . $partialPath, [], $userMeta->version);
        }
    }

    /**
     * Filter data for allowed key.
     * Remove all values those are not appears in $validKeys.
     *
     * @param array: $data
     * @param array: $validKeys
     *
     * @return array: filtered data
     */
    public static function filterData(array $data, array $validKeys)
    {
        foreach ($data as $key => $itm) {
            if (! in_array($key, $validKeys))
                unset($data[$key]);
        }

        return $data;
    }
}
