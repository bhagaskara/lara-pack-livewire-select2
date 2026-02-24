# Livewire Select2 Component

A custom Livewire V3 component wrapper for **Select2**. This component simplifies the usage of Select2 in your Livewire projects, supporting both static options arrays and AJAX-based remote data loading, along with multiple selections capabilities.

## Requirements

- PHP 8.1+
- Laravel 10+ / 11+
- Livewire ^3.0
- jQuery
- Select2 (JS & CSS)

## Installation

You can install the package via composer:

```bash
composer require lara-pack/livewire-select2
```

> **Note:** Ensure you have already included jQuery and Select2 assets in your layout file/app.

## Usage

You can use the component in your Livewire blade views using the `<livewire:... />` tag.

### 1. Basic Usage (Static Options)

Provide an array of arrays containing `id` and `text` keys.

```html
<livewire:lara-pack.livewire-select2
  wire:model="selectedCity"
  :options="[
        ['id' => '1', 'text' => 'Jakarta'],
        ['id' => '2', 'text' => 'Bandung'],
        ['id' => '3', 'text' => 'Surabaya']
    ]"
  placeholder="Pilih Kota"
/>
```

### 2. AJAX Remote Data (Load from API / URL)

Instead of passing static options, you can provide an endpoint URL. The component will handle the AJAX calls and debounce internally.

The API should return an array of objects structured as `[{ "id": 1, "text": "Option 1" }, ...]`.

```html
<livewire:lara-pack.livewire-select2
  wire:model="selectedUser"
  url="{{ route('api.users') }}"
  :minimumInputLength="3"
  placeholder="Cari user berdasarkan nama..."
/>
```

### 3. Multiple Selections

Enable multiple selection mode by passing `:multiple="true"`.

```html
<livewire:lara-pack.livewire-select2
  wire:model="selectedTags"
  url="{{ route('api.tags') }}"
  :multiple="true"
  placeholder="Pilih beberapa tag"
/>
```

### 4. Custom "Select All Filtered" for Multiple AJAX

This component comes with a special feature for AJAX Multiple Select. If you pass `:multipleSelection="true"`, an extra option _"--- Pilih Semua Yang Tampil ---"_ will appear at the top. Selecting it will fetch and select all data matching the search term.

```html
<livewire:lara-pack.livewire-select2
  wire:model="selectedProducts"
  url="{{ route('api.products') }}"
  :multiple="true"
  :multipleSelection="true"
/>
```

## Available Properties

| Property             | Type     | Default | Description                                                                                                           |
| -------------------- | -------- | ------- | --------------------------------------------------------------------------------------------------------------------- |
| `wire:model`         | `string` | `null`  | Bind the selected value. Must be `{ "id": ..., "text": ... }` for single select, or an array of objects for multiple. |
| `options`            | `array`  | `[]`    | Static array of options: `[['id'=>1, 'text'=>'Opt']]`.                                                                |
| `url`                | `string` | `""`    | The API Endpoint for AJAX data loading.                                                                               |
| `minimumInputLength` | `int`    | `0`     | Number of characters required to trigger the search.                                                                  |
| `placeholder`        | `string` | `""`    | Placeholder text for the input.                                                                                       |
| `allowClear`         | `bool`   | `true`  | Show a clear button (X) to reset the value.                                                                           |
| `dropdownParent`     | `string` | `""`    | Appends the dropdown to a specific element. Very useful inside Bootstrap Modals (e.g., `'#myModal'`).                 |
| `debounceTime`       | `int`    | `500`   | Delay in milliseconds before firing the AJAX request.                                                                 |
| `class`              | `string` | `''`    | Extra CSS classes injected directly to the `<select>` element.                                                        |
| `theme`              | `string` | `''`    | Select2 theme (e.g., `'bootstrap-5'`).                                                                                |
| `multiple`           | `bool`   | `false` | Set to true to allow arrays of selections.                                                                            |
| `multipleSelection`  | `bool`   | `false` | When true in AJAX `multiple` mode, allows selecting all loaded search results at once.                                |
| `disabled`           | `bool`   | `false` | Disables the Select2 input entirely.                                                                                  |

## Data Binding & Format

Because Livewire components pass data over the wire, **the bound value representation is always an object or an array of objects**, representing the selected `id` and `text`.

For single selection:

```php
// In your Livewire Component Controller
public $selectedCity = ['id' => '1', 'text' => 'Jakarta'];
```

For multiple selections:

```php
// In your Livewire Component Controller
public $selectedTags = [
    ['id' => '1', 'text' => 'PHP'],
    ['id' => '2', 'text' => 'Laravel']
];
```

## Troubleshooting: Modals

If your Select2 input isn't clickable or doesn't show properly inside a Bootstrap Modal, you need to set the `dropdownParent` property to target your modal element.

```html
<livewire:lara-pack.livewire-select2 ... dropdownParent="#yourModalId" />
```

## License

This package is distributed under the [MIT license](LICENSE).
