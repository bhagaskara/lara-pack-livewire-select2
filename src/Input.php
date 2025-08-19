<?php

namespace LaraPack\LivewireSelect2;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Input extends Component
{
    #[Modelable]
    public $value;

    #[Locked]
    public string $objId;

    // Config
    public $options = [];
    public $url = "";
    public $minimumInputLength = 0;
    public $placeholder = "";
    public $allowClear = true;
    public $dropdownParent = "";
    public $debounceTime = 500; // ms
    public $class = '';
    public $theme = '';
    public $multiple = false;
    public $multipleSelection = false;
    public $disabled = false;

    public function mount(): void
    {
        $this->objId = 'select2-' . Str::uuid()->toString();

        // HANDLE: Mark Option As Selected
        if (count($this->options) && $this->value) {
            if ($this->multiple) {
                foreach ($this->value as $item) {
                    foreach ($this->options as $index => $option) {
                        if ($option['id'] == $item['id']) {
                            $this->options[$index]['selected'] = true;
                            break;
                        }
                    }
                }
            } else {
                foreach ($this->options as $index => $option) {
                    if ($option['id'] == $this->value['id']) {
                        $this->options[$index]['selected'] = true;
                        break;
                    }
                }
            }
        }
    }

    public function render(): View
    {
        return view('lara-pack.livewire-select2::input');
    }
}
