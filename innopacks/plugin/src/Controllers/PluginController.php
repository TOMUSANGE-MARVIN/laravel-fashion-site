<?php
/* */

namespace InnoShop\Plugin\Controllers;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use InnoShop\Plugin\Core\Plugin;
use InnoShop\Plugin\Repositories\SettingRepo;
use InnoShop\Plugin\Resources\PluginResource;
use InnoShop\Plugin\Services\PluginService;
use Throwable;

class PluginController
{
    /**
     * Get all plugins.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $plugins = app('plugin')->getPlugins();
        $type    = $request->get('type');

        if ($type && in_array($type, Plugin::TYPES)) {
            $plugins = $plugins->where('type', $type);
        }

        $data = [
            'types'   => Plugin::TYPES,
            'type'    => $type,
            'plugins' => array_values(PluginResource::collection($plugins)->jsonSerialize()),
        ];

        return inno_view('plugin::plugins.index', $data);
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        try {
            $code   = $request->get('code');
            $plugin = app('plugin')->getPluginOrFail($code);
            PluginService::getInstance()->installPlugin($plugin);

            return json_success(panel_trans('common.saved_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  $code
     * @return mixed
     */
    public function destroy($code): mixed
    {
        try {
            $plugin = app('plugin')->getPluginOrFail($code);
            PluginService::getInstance()->uninstallPlugin($plugin);

            return json_success(panel_trans('common.deleted_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  $code
     * @return View
     */
    public function edit($code): View
    {
        try {
            $plugin = app('plugin')->getPluginOrFail($code);
            $view   = $plugin->getFieldView() ?: 'plugin::plugins.form';
            $data   = [
                'view'   => $view,
                'plugin' => $plugin,
                'fields' => $plugin->getFields(),
            ];

            return inno_view($view, $data);
        } catch (Exception $e) {
            $plugin = app('plugin')->getPlugin($code);
            $data   = [
                'error'       => $e->getMessage(),
                'plugin_code' => $code,
                'plugin'      => $plugin,
            ];

            return inno_view('plugin::plugins.error', $data);
        }
    }

    /**
     * @param  Request  $request
     * @param  string  $code
     * @return mixed
     * @throws Throwable
     */
    public function update(Request $request, string $code): mixed
    {
        $fields = $request->all();
        $plugin = app('plugin')->getPluginOrFail($code);
        if (method_exists($plugin, 'validateFields')) {
            $validator = $plugin->validateFields($fields);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }
        SettingRepo::getInstance()->updateValues($fields, $code);
        $currentUrl = panel_route('plugins.edit', [$code]);

        return redirect($currentUrl)
            ->with('instance', $plugin)
            ->with('success', panel_trans('common.updated_success'));
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function updateStatus(Request $request): mixed
    {
        try {
            $code    = $request->get('code');
            $enabled = $request->get('enabled');
            app('plugin')->getPluginOrFail($code);
            SettingRepo::getInstance()->updatePluginValue($code, 'active', $enabled);

            return json_success(panel_trans('common.updated_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        } catch (Throwable $e) {
            return json_fail($e->getMessage());
        }
    }
}
