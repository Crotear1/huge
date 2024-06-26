<div class="container">
    <h1>Request a password reset</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <!-- request password reset form box -->
        <form method="post" action="<?php echo Config::get('URL'); ?>login/requestPasswordReset_action">
            <label for="user_name_or_email">
                Enter your username or email and you'll get a mail with instructions:
                <input type="text" name="user_name_or_email" required />
            </label>

        </form>

    </div>
</div>

