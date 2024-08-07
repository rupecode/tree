<?php $this->layout('layout') ?>

<div class="container-fluid head">
    <div class="row">
        <div class="col-6">
            <h2>Tree app</h2>
        </div>
        <div class="col">
        </div>
        <div class="col-md-auto">
            <button class="btn btn-link btnLogout">Logout</button>
        </div>
    </div>
</div>


<div class="container-lg">
    <div data-id="0">
        <button type='button' class='btn btn-outline-primary btn-sm addBtn'>Add</button>
    </div>

    <div>
        <?php
            function printNodes($allNodes): void
            {
                /** @var \BlueM\Tree\Node $node */
                foreach ($allNodes as $node) {
                    $padding = 20 * ($node->getLevel() - 1);
                    echo "<div style='padding-left: {$padding}px' class='nodeLine' 
                        data-parent='{$node->getParent()->get('id')}'  
                        data-id='{$node->get('id')}'>{$node->get('name')}
                            <button type='button' class='btn btn-outline-primary btn-sm addBtn'>Add</button> 
                            <button type='button' class='btn btn-outline-primary btn-sm editBtn'>Edit</button>
                            <button type='button' class='btn btn-outline-danger btn-sm deleteBtn'>Delete</button>
                        </div>";

                    if ($node->hasChildren()) {
                        printNodes($node->getChildren());
                    }
                }
            }
        ?>
        <?php /** @var \BlueM\Tree  $tree */ $rootNodes = $tree->getRootNodes(); ?>

        <?php printNodes($rootNodes) ?>

    </div>

</div>

<?php $this->insert('Modals/addModal') ?>
<?php $this->insert('Modals/editModal', ['rootNodes' => $rootNodes]) ?>


<script>

    function clearForm() {
        $('.nameInput').val('')
        $('.descriptionInput').val('')
    }

    $(function () {
        $('.btnLogout').on('click', function (e) {
            $.ajax({
                url: '/?action=index/logout',
                cache: false,
                type: "POST",
                success: function (data) {
                    document.location.href = '/';
                }
            }).fail(function() {
            });
        });

        $('.editForm').validate({
            errorElement: 'div',
            submitHandler: function(form) {
                $('#editModal').modal('hide');

                $.ajax({
                    url: $(form).attr("action"),
                    cache: false,
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.error) {
                            return false;
                        } else {
                            document.location.reload()

                            return false;
                        }
                    }
                }).fail(function() {
                    return false;
                });

                return false;
            }
        });

        $('.editBtn').on('click', function (e) {
            clearForm();

            var id = $(this).closest('div').attr('data-id');
            $('.idInput').val(id);

            var parent = $(this).closest('div').attr('data-parent');
            console.log(parent)
            $('.parentInput option[value="' + parent + '"]').prop('selected', true)

            $.ajax({
                url: '/?action=tree/get',
                cache: false,
                type: "POST",
                data: {id: id},
                success: function (data) {
                    $('.nameInput').val(data.data.name)
                    $('.descriptionInput').val(data.data.description)
                }
            }).fail(function() {
            });

            $('#editModal').modal('show');
        });

        $('.deleteBtn').on('click', function (e) {
            var id = $(this).closest('div').attr('data-id');

            $.ajax({
                url: '/?action=tree/delete',
                cache: false,
                type: "POST",
                data: {id: id},
                success: function (data) {
                    if (data.error) {
                        return false;
                    } else {
                        document.location.reload()

                        return false;
                    }
                }
            }).fail(function() {
                return false;
            });

            return false;
        })

        $('.addBtn').on('click', function (e) {
            clearForm();
            var id = $(this).closest('div').attr('data-id');
            $('.idInput').val(id);
            $('#exampleModal').modal('show');
        });

        $('.addForm').validate({
            errorElement: 'div',
            submitHandler: function(form) {
                $('#exampleModal').modal('hide');

                $.ajax({
                    url: $(form).attr("action"),
                    cache: false,
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.error) {
                            return false;
                        } else {
                            document.location.reload()

                            return false;
                        }
                    }
                }).fail(function() {
                    return false;
                });

                return false;
            }
        });
    })
</script>