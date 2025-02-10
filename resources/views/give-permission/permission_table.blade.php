<table class="table">
    <thead class="table-primary">
        <tr>
            <th scope="col">Menu</th>
            <th scope="col">
                Actions
                <input type="checkbox" id="selectAll" />
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach (loadMenus(true) as $menu)
            <tr>
                <td>
                    <h4>{{ $menu->name }}</h4>
                </td>
                <td>
                    <label class="d-block" for="chk-ani">
                        <input class="checkbox_animated" type="checkbox"
                            @if (in_array($menu->url, $role_permissions)) @checked(true) @endif
                            name="permission_collection[]" value="{{ $menu->url }}"> read
                    </label>
                </td>
            </tr>
            @if (!$menu->is_single)
                @foreach (loadSubMenus($menu->id, true) as $submenu)
                    <tr>
                        <td>
                            <h6>* {{ $submenu->name }}</h6>
                        </td>
                        <td>
                            @foreach (loadPermissionByUrlLite($menu->url . $submenu->url, strlen($menu->url . $submenu->url)) as $item)
                                @php
                                    if (substr($item->name, 0, 1) == '/') {
                                        $item_name = substr($item->name, 1);
                                        $segments = explode('/', $item_name);
                                        $segment1 = $segments[0] ?? '';
                                        $segment2 = $segments[1] ?? '';
                                        $segment3 = $segments[2] ?? 'read';
                                        $segment4 = array_slice($segments, 3);
                                    } else {
                                        $segments = explode('/', $item->name);
                                        $segment1 = $segments[0] ?? '';
                                        $segment2 = $segments[1] ?? '';
                                        $segment3 = $segments[2] ?? 'read';
                                        $segment4 = array_slice($segments, 3);
                                    }
                                @endphp
                                <label class="d-inline-block" for="chk-ani">
                                    <input class="checkbox_animated" type="checkbox"
                                        @if (in_array($item->name, $role_permissions)) @checked(true) @endif
                                        name="permission_collection[]" value="{{ $item->name }}">
                                    {{ $segment4 ? $segment3 . ' ' . implode(' ', $segment4) : $segment3 }}
                                </label>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @endif
        @endforeach

    </tbody>
</table>

{{-- detail dari role id --}}
<input type="hidden" name="id" id="id" value="{{ $detail['id'] }}">

<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.checkbox_animated');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('selectAll').checked;
        });
    });

    document.querySelectorAll('.checkbox_animated').forEach(function(checkbox) {
        checkbox.addEventListener('click', function() {
            let allCheckboxes = document.querySelectorAll('.checkbox_animated');
            let allChecked = true;
            allCheckboxes.forEach(function(cbox) {
                if (!cbox.checked) {
                    allChecked = false;
                }
            });
            document.getElementById('selectAll').checked = allChecked;
        });
    });
</script>
