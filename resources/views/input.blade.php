<div wire:ignore>
    <select class="{{ $class }}" id="{{ $objId }}" {{ $multiple ? 'multiple' : '' }} style="width:100%"
        @disabled($disabled)>
        @foreach ($options as $option)
            <option value="{{ $option['id'] }}"
                {{ isset($option['selected']) && $option['selected'] ? 'selected' : '' }}>
                {{ $option['text'] }}
            </option>
        @endforeach

        @if ($value && count($options) == 0)
            @if ($multiple)
                @foreach ($value as $item)
                    <option value="{{ $item['id'] }}" selected>{{ $item['text'] }}</option>
                @endforeach
            @else
                <option value="{{ $value['id'] }}" selected>{{ $value['text'] }}</option>
            @endif
        @endif
    </select>
</div>

@script
    <script>
        const objId = "#{{ $objId }}";
        const minimumInputLength = {{ $minimumInputLength }};
        const placeholder = "{{ $placeholder }}";
        const allowClear = {{ $allowClear ? 'true' : 'false' }};
        const dropdownParent = "{{ $dropdownParent }}";
        const url = "{{ $url }}";
        const theme = "{{ $theme }}";
        const debounceTime = {{ $debounceTime }};
        const multiple = {{ $multiple ? 1 : 0 }};
        const multipleSelection = {{ $multipleSelection ? 1 : 0 }};

        $(() => {
            let config = {
                width: 'style'
            };

            if (minimumInputLength) {
                config.minimumInputLength = minimumInputLength;
            }

            if (theme) {
                config.theme = theme;
            }

            if (placeholder) {
                config.placeholder = placeholder;
            }

            if (allowClear) {
                config.allowClear = allowClear;
            }

            if (dropdownParent) {
                config.dropdownParent = dropdownParent;
            }

            if (url) {
                config.ajax = {
                    url: url,
                    dataType: 'json',
                    delay: debounceTime,
                    processResults: (data, params) => {
                        const results = $.map(data, (item) => {
                            return {
                                "id": item.id,
                                "text": item.text,
                            }
                        });

                        if (multiple && multipleSelection) {
                            if (results.length > 1) {
                                results.unshift({
                                    id: '_typed_' + params.term,
                                    text: '--- Pilih Semua Yang Tampil ---'
                                });
                            }
                        }

                        return {
                            results: results
                        };
                    },
                };
            }
            $(objId).select2(config);

            if (multiple && multipleSelection) {
                $(objId).on("select2:selecting", (e) => {
                    if (e.params.args.data.id.toString().startsWith('_typed_')) {
                        e.preventDefault();
                        $(e.target).select2('close');

                        let $select = $(e.target);
                        let params = {
                            q: e.params.args.data.id.toString().replace('_typed_', ''),
                        };

                        // Show loading indicator
                        let container = $select.next('.select2-container');
                        container.addClass('loading');

                        // Fetch all matching options
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            data: params,
                            success: function(data) {
                                data.forEach(element => {
                                    $(e.target).append(new Option(element.text, element
                                        .id, true, true));
                                });
                                container.removeClass('loading');
                                $(e.target).trigger('change');
                            }
                        });
                    }
                });
            }

            $(objId).on("change", (e) => {
                if (multiple) {
                    const selectedData = $(objId).select2('data').map(item => ({
                        id: item.id,
                        text: item.text
                    }));
                    @this.set('value', selectedData);
                } else {
                    @this.set('value', {
                        id: $(objId).val(),
                        text: $(objId).find("option:selected").text()
                    });
                }
            })

        });
    </script>
@endscript

@pushOnce('css')
    <style>
        .select2-container.loading {
            position: relative;
        }

        .select2-container.loading:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        .select2-container.loading:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-top: -10px;
            margin-left: -10px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            z-index: 2;
            animation: select2Spin 1s linear infinite;
        }

        @keyframes select2Spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpushOnce
