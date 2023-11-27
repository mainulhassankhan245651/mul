@php
    $popularCategorySection = json_decode($popularCategorySection->value);
@endphp

@php
    $subCategories = \App\Models\SubCategory::where('category_id', $popularCategorySection[0]->category)->get();
@endphp

@php
    $childCategories = \App\Models\ChildCategory::where('sub_category_id', $popularCategorySection[0]->sub_category)->get();
@endphp

<div class="tab-pane fade" id="list-profile-MAINUL" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.popular-category-section')}}" method="POST">
                @csrf
                @method('PUT')
                <div id="dynamicTable">
                    <h5>Category 1</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="addmore[0][cat_one]" class="form-control main-category">
                                    <option value="">Select</option>
                                    @foreach ($categories as $category)
                                        <option {{$category->id == $popularCategorySection[0]->category ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @php
                                $subCategories = \App\Models\SubCategory::where('category_id', $popularCategorySection[0]->category)->get();
                                @endphp
                                <label>Sub Category</label>
                                <select name="addmore[0][sub_cat_one]" id="" class="form-control sub-category">
                                    <option value="">select</option>
                                    @foreach ($subCategories as $subCategory)
                                    <option {{$subCategory->id == $popularCategorySection[0]->sub_category ? 'selected' : ''}} value="{{$subCategory->id}}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @php
                                $childCategories = \App\Models\ChildCategory::where('sub_category_id', $popularCategorySection[0]->sub_category)->get();
                                @endphp
                                <label>Child Category</label>
                                <select name="addmore[0][child_cat_one]" id="" class="form-control child-category">
                                    <option value="">select</option>
                                    @foreach ($childCategories as $childCategory)
                                        <option {{$childCategory->id == $popularCategorySection[0]->child_category ? 'selected' : ''}} value="{{$childCategory->id}}">{{ $childCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                    </div>
                </div>
                </br></br>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.main-category', function(e) {
                let id = $(this).val();
                let row = $(this).closest('.row');

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-subcategories') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        let selector = row.find('.sub-category');
                        selector.html('<option value="">Select</option>')

                        $.each(data, function(i, item) {
                            selector.append(
                                `<option value="${item.id}">${item.name}</option>`)
                        })
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })

            /** get child categories **/
            $('body').on('change', '.sub-category', function(e) {
                let id = $(this).val();
                let row = $(this).closest('.row');
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.product.get-child-categories') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        let selector = row.find('.child-category');
                        selector.html('<option value="">Select</option>')

                        $.each(data, function(i, item) {
                            selector.append(
                                `<option value="${item.id}">${item.name}</option>`)
                        })
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            })

        })
        
    </script>

<script type="text/javascript">
    var i = 0;

    $("#add").click(function(){
        ++i;

        var newRowHtml = `<div class="container">
            <div class="row">
                <div class="col-md-4">
                    <select name="addmore[${i}][cat_one]" class="form-control main-category">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                            <option @if($category->id == $popularCategorySection[0]->category) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="addmore[${i}][sub_cat_one]" id="" class="form-control sub-category">
                        <option value="">select</option>
                        @foreach ($subCategories as $subCategory)
                            <option @if($subCategory->id == $popularCategorySection[0]->sub_category) selected @endif value="{{$subCategory->id}}">{{ $subCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="addmore[${i}][child_cat_one]" id="" class="form-control child-category">
                        <option value="">select</option>
                        @foreach ($childCategories as $childCategory)
                            <option @if($childCategory->id == $popularCategorySection[0]->child_category) selected @endif value="{{$childCategory->id}}">{{ $childCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-tr">Remove</button>
                </div>
            </div>
        </div>`;

        $("#dynamicTable").append(newRowHtml);
    });

    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('.container').remove();
    });
</script>


@endpush
