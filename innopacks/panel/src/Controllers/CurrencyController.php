<?php
/* */

namespace InnoShop\Panel\Controllers;

use Exception;
use Illuminate\Http\Request;
use InnoShop\Common\Models\Currency;
use InnoShop\Common\Repositories\CurrencyRepo;
use InnoShop\Panel\Requests\CurrencyRequest;
use Throwable;

class CurrencyController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request): mixed
    {
        $filters = $request->all();
        $data    = [
            'criteria'   => CurrencyRepo::getCriteria(),
            'currencies' => CurrencyRepo::getInstance()->list($filters),
        ];

        return inno_view('panel::currencies.index', $data);
    }

    /**
     * @param  Currency  $currency
     * @return Currency
     */
    public function show(Currency $currency): Currency
    {
        return $currency;
    }

    /**
     * Currency creation page.
     *
     * @return mixed
     * @throws Exception
     */
    public function create(): mixed
    {
        return $this->form(new Currency);
    }

    /**
     * @param  CurrencyRequest  $request
     * @return mixed
     * @throws Throwable
     */
    public function store(CurrencyRequest $request): mixed
    {
        try {
            $data = $request->all();
            CurrencyRepo::getInstance()->create($data);

            return json_success(panel_trans('common.saved_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  Currency  $currency
     * @return mixed
     * @throws Exception
     */
    public function edit(Currency $currency): mixed
    {
        return $this->form($currency);
    }

    /**
     * @param  $currency
     * @return mixed
     * @throws Exception
     */
    public function form($currency): mixed
    {
        $data = [
            'currency' => $currency,
        ];

        return inno_view('panel::currencies.form', $data);
    }

    /**
     * @param  CurrencyRequest  $request
     * @param  Currency  $currency
     * @return mixed
     */
    public function update(CurrencyRequest $request, Currency $currency): mixed
    {
        try {
            $data = $request->all();
            CurrencyRepo::getInstance()->update($currency, $data);

            return json_success(panel_trans('common.updated_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  Currency  $currency
     * @return mixed
     */
    public function destroy(Currency $currency): mixed
    {
        try {
            if ($currency->code == system_setting('currency')) {
                throw new Exception(panel_trans('currency.cannot_delete_default_currency'));
            }
            CurrencyRepo::getInstance()->destroy($currency);

            return json_success(panel_trans('common.deleted_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return mixed
     * @throws Throwable
     */
    public function active(Request $request, int $id): mixed
    {
        try {
            $item = Currency::query()->findOrFail($id);

            if ($item->code == system_setting('currency')) {
                throw new Exception(panel_trans('currency.cannot_disable_default_currency'));
            }

            $item->active = $request->get('status');
            $item->saveOrFail();

            return json_success(panel_trans('common.updated_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
