<div class="table overflow-auto" tabindex="8">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">عنوان جستجو</label>
        <div class="col-sm-10">
            <input type="text" class="form-control text-left" dir="rtl" wire:model.live="search">
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead class="thead-light">
        <tr>
            <th class="text-center align-middle text-primary">ردیف</th>
            <th class="text-center align-middle text-primary">عکس</th>
            <th class="text-center align-middle text-primary">نام برند</th>
            <th class="text-center align-middle text-primary">ویرایش</th>
            <th class="text-center align-middle text-primary">حذف</th>
            <th class="text-center align-middle text-primary">تاریخ ایجاد</th>
        </tr>
        </thead>
        <tbody>
        @foreach($brands as $index => $brand)


            <tr>
                <td class="text-center align-middle">{{$brands->firstItem() + $index}}</td>
                <td class="text-center align-middle">
                    <figure class="avatar avatar">
                        <img src="{{url('images/admin/brands/small/'.$brand->image)}}" class="rounded-circle" alt="image">
                    </figure>
                </td>
                <td class="text-center align-middle">{{$brand->title}}</td>
                <td class="text-center align-middle">
                    <a class="btn btn-outline-info" href="{{route('brands.edit',$brand->id)}}">
                        ویرایش
                    </a>
                </td>
                <td class="text-center align-middle">
                    <a class="btn btn-outline-danger" wire:click="deleteBrand({{$brand->id}})">
                        حذف
                    </a>
                </td>
                <td class="text-center align-middle">{{Hekmatinasser\Verta\Verta::instance($brand->created_at)->format('%B %d، %Y')}}</td>
            </tr>

        @endforeach
    </table>
    <div style="margin: 40px !important;"
         class="pagination pagination-rounded pagination-sm d-flex justify-content-center">
        {{$brands->appends(Request::except('page'))->links()}}
    </div>
</div>
@section('scripts')
    <script>
        window.addEventListener('deleteBrand',event=>{
            Swal.fire({
                title: "آیا ازحذف اسلایدر مطمئن هستید؟",
                text: "امکان بازیابی بعد از حذف وجود ندارد!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "بله",
                cancelButtonText: "خیر",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('destroyBrand', {id:event.detail[0].id})
                    Swal.fire({
                        title: "اسلایدر با موفقیت حذف شد",
                        icon: "success"
                    });
                }
            });
        })
    </script>
@endsection
