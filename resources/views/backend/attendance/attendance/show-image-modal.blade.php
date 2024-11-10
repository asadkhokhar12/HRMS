<div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
           <div class="modal-header modal-header-image mb-3">
               <h5 class="modal-title text-white">{{ $data['title'] }}</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                   <i class="fa fa-times text-white" aria-hidden="true"></i>
               </button>
           </div>
            <div class="modal-body">
                <img src="{{ $data['image'] }}" class="img-cover">         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>