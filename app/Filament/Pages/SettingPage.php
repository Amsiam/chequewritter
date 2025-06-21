<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Exception;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use stdClass;

class SettingPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.setting-page';

    public $form = [];

    public $formFields =  [
        ['label' => 'Shift Left', 'name' => 'shift_left', 'type' => 'number'],
        ['label' => 'Shift Up', 'name' => 'shift_up', 'type' => 'number'],
        ['label' => 'Payee Prefix', 'name' => 'payee_prefix', 'type' => 'text'],
        ['label' => 'Payee Suffix', 'name' => 'payee_suffix', 'type' => 'text'],
        ['label' => 'Amount Prefix', 'name' => 'amount_prefix', 'type' => 'text'],
        ['label' => 'Amount Suffix', 'name' => 'amount_suffix', 'type' => 'text'],
        ['label' => 'Amount Wording Prefix', 'name' => 'amount_wording_prefix', 'type' => 'text'],
        ['label' => 'Amount Wording Suffix', 'name' => 'amount_wording_suffix', 'type' => 'text'],
        ['label' => 'Print Amount in Capital', 'name' => 'print_amount_in_capital', 'type' => 'checkbox'],
        ['label' => 'Print Tailing Zero', 'name' => 'print_tailing_zero', 'type' => 'checkbox'],
    ];

    public function mount()
    {
        $this->form = Cache::rememberForever('setting_' . Auth::user()->id, function () {
            $settings = Setting::where('user_id', Auth::id())->select('key', 'value')->get();

            $keyValue = new stdClass();

            foreach ($settings as $setting) {

                $formType = array_find($this->formFields, function ($field) use ($setting) {
                    if ($field['name'] == $setting->key) {
                        return true;
                    }
                });

                if ($formType['type'] == 'checkbox') {
                    $keyValue->{$setting->key} = $setting->value ? true : false;
                } else {
                    $keyValue->{$setting->key} = $setting->value;
                }
            }

            return $keyValue;
        });
    }

    public function save()
    {

        try {
            foreach ($this->form as $key => $value) {
                Setting::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'key' => $key
                    ],
                    [
                        'value' => $value
                    ]
                );
            }

            Cache::forget('setting_' . Auth::id());

            Notification::make()->title('Setting Updated Successfully')->success()->send();
        } catch (Exception $e) {

            $randomNumber = rand(100000, 9999999999);
            Log::error($randomNumber . ':Setting Update Failed', $e);
            Notification::make()->title('Setting Updated Failed. Error No: ' . $randomNumber)
                ->danger()->send();
        }
    }
}
