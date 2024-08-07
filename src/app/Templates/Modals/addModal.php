<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add node</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="addForm" action="/?action=tree/add" method="post">
                <input type="hidden" name="id" class="idInput"/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input class="form-control nameInput" name="name" required>
                        <div class="error"></div>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <input class="form-control descriptionInput" name="description" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary saveBtn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
