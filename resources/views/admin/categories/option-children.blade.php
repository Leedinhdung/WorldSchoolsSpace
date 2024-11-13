@if (!isset($getCategoryById))
    @foreach ($children as $child)
        <option value="{{ $child->id }}">{{ $prefix }} {{ $child->name }}</option>
        @if (!empty($child->children))
            @include('admin.categories.option-children', [
                'children' => $child->children,
                'prefix' => $prefix . '-',
            ])
        @endif
    @endforeach
@else
    @foreach ($children as $childCategory)
        @if ($childCategory->id !== $getCategoryById->id)
            <!-- Bỏ qua danh mục đang sửa -->
            <option value="{{ $childCategory->id }}"
                {{ $childCategory->id == $getCategoryById->parent_id ? 'selected' : '' }}>
                {{ $prefix }} {{ $childCategory->name }}
            </option>

            @if (!empty($childCategory->children))
                @include('admin.categories.option-children', [
                    'children' => $childCategory->children,
                    'prefix' => $prefix . '-',
                    'getCategoryById' => $getCategoryById,
                ])
            @endif
        @endif
    @endforeach
@endif

@if (isset($post))
    @foreach ($children as $childCategory)
        @if ($childCategory->id !== $post->category_id)
            <!-- Bỏ qua danh mục đang sửa -->
            <option value="{{ $childCategory->id }}"
                {{ $childCategory->id == $post->category_id ? 'selected' : '' }}>
                {{ $prefix }} {{ $childCategory->name }}
            </option>

            @if (!empty($childCategory->children))
                @include('admin.categories.option-children', [
                    'children' => $childCategory->children,
                    'prefix' => $prefix . '-',
                    'post' => $post,
                ])
            @endif
        @endif
    @endforeach
@endif
