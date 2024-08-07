<?php $this->layout('layout') ?>


<div class="d-flex align-items-center justify-content-center" style="padding-top: 40px; padding-bottom: 40px;">
    <h1>Tree App</h1>
</div>

<div class="d-flex align-items-center justify-content-center">
    <div class="w-25">
        <form method="post" class="loginForm" action="/?action=index/login">
            <div class="mb-3 errorMessage"></div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
                <div class="error"></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<script>
    function errorShow(message) {
        $('.errorMessage').html(message).show();
    }

    function errorHide() {
        $('.errorMessage').hide().html('');
    }

    $(function () {
        $('.loginForm').validate({
            errorElement: 'div',
            submitHandler: function(form) {
                errorHide();

                $.ajax({
                    url: $(form).attr("action"),
                    cache: false,
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.error) {
                            errorShow(data.message);

                            return false;
                        } else {
                            document.location.href = '/?action=tree/index';

                            return false;
                        }
                    }
                }).fail(function() {
                    return false;
                });

                return false;
            }
        });
    });
</script>