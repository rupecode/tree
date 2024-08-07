<?php
function printSelectNodes($allNodes): void
{
    /** @var \BlueM\Tree\Node $node */
    foreach ($allNodes as $node) {
        $padding = str_repeat('-', $node->getLevel());
        echo "<option value='{$node->get('id')}'> {$padding} {$node->get('name')}</option>";

        if ($node->hasChildren()) {
            printSelectNodes($node->getChildren());
        }
    }
}
?>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit node</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="editForm" action="/?action=tree/edit" method="post">
                <input type="hidden" name="id" class="idInput"/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Parent node</label>
                        <select class="form-control parentInput" name="parent">
                            <option value="0">Root level</option>
                            <?php printSelectNodes($rootNodes) ?>
                        </select>
                    </div>
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
                    <button type="submit" class="btn btn-primary saveEditBtn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
