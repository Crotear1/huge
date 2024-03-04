
<!-- CSS DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    $('.dataTable').DataTable();
} );
</script>
<div class="container">

    <h1>Admin/index</h1>


    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <div>
            This controller/action/view shows a list of all users in the system. with the ability to soft delete a user
            or suspend a user.
        </div>
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
                        <td>
                            <div class="dropdown">
                                <button href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_account_type; ?>" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?= $user->user_account_type; ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php
                                        $items = $this->userRoles;
                                        foreach ($items as $item) {
                                            echo '<a class="dropdown-item" >'.json_encode($item->RoleName).' </a>';
                                        }


                                    ?>
                                </div>
                            </div>
                        </td>
                        <form action="<?= config::get("URL"); ?>admin/actionAccountSettings" method="post">
                            <td><input type="number" name="suspension" /></td>
                            <td><input type="checkbox" name="softDelete" <?php if ($user->user_deleted) { ?> checked <?php } ?> /></td>
                            <td>    echo "<a class='dropdown-item' </a>";
                                        }
                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                <input type="submit" />
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
