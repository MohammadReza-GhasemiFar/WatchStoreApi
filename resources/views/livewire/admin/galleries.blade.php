<div class="mt-5 row">
    @foreach($galleries as $gallery)
    <div class="p-2 border col-md-4 d-flex justify-content-around align-items-center border-danger">
        <img src="{{url('/images/admin/products/big/'.$gallery->image)}}" style="width: 100px;" alt="">
        <div>
            <button wire:click="deleteGallery({{$product_id}},{{$gallery->id}})" class="btn btn-info"><i  class="fa fa-trash"></i></button>
        </div>
    </div>
    @endforeach
</div>
@section('scripts')
    <script>
        window.addEventListener('deleteGallery',event=>{
            Swal.fire({
                title: "آیا ازحذف عکس مطمئن هستید؟",
                text: "امکان بازیابی بعد از حذف وجود ندارد!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "بله",
                cancelButtonText: "خیر",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('destroyGallery',{product_id:event.detail[0].product_id,id:event.detail[0].id});
                    Swal.fire({
                        title: "عکس با موفقیت حذف شد",
                        icon: "success"
                    });
                }
            });
        })
    </script>
@endsection
