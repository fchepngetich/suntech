<div class="modal fade" id="edit-sub-category-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= route_to('update-subcategory')?>" id="update_subcategory_form" method="post">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    SubCategory Title
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?= csrf_token()?>" value="<?= csrf_hash()?>" class="ci_csrf_data">
                <input type="hidden" name="subcategory_id">
                <div class="form-group">
                    <label for=""><b>Parent Category</b></label>
                    <select name="parent_cat" id="" class="form-control">

                    <option value="">Uncategorized</option>
                    </select>                </div>
                <div class="form-group">
                    <label for=""><b>Sub Category name</b></label>
                    <input type="text" name="subcategory_name" class="form-control" required placeholder="Enter subcategory name">
                    <span class="text-danger error subcategory_name_error"></span>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="description" class="form-control" cols="10" rows="7" placeholder="Type..." id="">

                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary action">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>