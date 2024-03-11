
<div class="container">

    <h1>Admin/index</h1>


    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <div>
            <table class="overview-table dataTable">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                    <td>Activated ?</td>
                    <td>Link to user's profile</td>
                    <td>Rights</td>
                    <td>suspension Time in days</td>
                    <td>Soft delete</td>
                    <td>Submit</td>
                </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>"/>
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->user_email; ?></td>
                        <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                        <td>
                            <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">Profile</a>
                        </td>
                        <form action="<?= config::get("URL"); ?>admin/actionAccountSettings" method="post">
                            <td>
                                <select class="form-control" style="width: 100px;" name="new_role_id" aria-label="Default select example">
                                <?php
                                    $roles = [];
                                    foreach ($this->userRoles as $role) {
                                        $roles[$role->RoleID] = $role;
                                    }
                                    $roleName = $roles[$user->user_account_type]->RoleName;
                                ?>
                                    <option selected> <?php echo $roleName; ?> </option>
                                    <?php
                                        foreach ($this->userRoles as $role) {
                                            echo "<option value='$role->RoleID'>$role->RoleName</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                            <td><input type="number" class="form-control" name="suspension" /></td>
                            <td><input type="checkbox" name="softDelete" <?php if ($user->user_deleted) { ?> checked <?php } ?> /></td>
                            <td>
                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                <input type="submit" class="btn btn-secondary" />
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
