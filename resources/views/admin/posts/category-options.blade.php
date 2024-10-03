@foreach($categories as $category)
    <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
        {{ str_repeat('-', $depth) . $category->name }}
    </option>

    @if (isset($category->children))
        @include('admin.posts.category-options', ['categories' => $category->children, 'depth' => $depth + 1])
    @endif
@endforeach
