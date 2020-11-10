@foreach($sub_categories as $subcategory)
    <ul>
        <li>
            <a href="#">
                {{$subcategory->title}}
            </a>
        </li>
        @if(count($subcategory->subcategory))
            @include('frontend.header.category.sub_category_list',['sub_categories' => $subcategory->subcategory])
        @endif
    </ul>
@endforeach

