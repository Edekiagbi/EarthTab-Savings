<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin
$user_role = $_SESSION['user_role'];

$task_id = $_GET['task_id'];

if (isset($_POST['update_task_info']) && $user_role == 1) { // Only allow updates for admin users
    $obj_admin->update_task_info($_POST, $task_id, $user_role);
}

$page_name = "Edit Task";
include("include/sidebar.php");

$sql = "SELECT * FROM task_info WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<!--modal for employee add-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="well">
                        <h3 class="text-center bg-primary" style="padding: 7px;">Edit Savings Record</h3><br>

                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Customer ID</label>
                                        <div class="col-sm-7">
                                            <input type="text" placeholder="Amount Saved" id="task_title" name="task_title" class="form-control" value="<?php echo $row['t_title']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?> required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Phone Number</label>
                                        <div class="col-sm-7">
                                            <textarea name="task_description" id="task_description" placeholder="Phone Number" class="form-control" rows="5" cols="5" <?php if ($user_role != 1) { ?> readonly <?php } ?>><?php echo $row['t_description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Amount Saved</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="t_start_time" id="t_start_time" class="form-control" value="<?php echo $row['t_start_time']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Total Amount Saved</label>
                                        <div class="col-sm-7">
                                            <input type="text" placeholder="" id="t_a" name="t_a" class="form-control" value="<?php echo $row['t_a']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?> required>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Date</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="t_end_time" id="t_end_time" class="form-control" value="<?php echo $row['t_end_time']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Savings Status</label>
                                        <div class="col-sm-7">
                                            <input type="text" placeholder="" id="t_sta" name="t_sta" class="form-control" value="<?php echo $row['t_sta']; ?>" <?php if ($user_role != 1) { ?> readonly <?php } ?> required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Customer</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="assign_to" id="assign_to" <?php if ($user_role != 1) { ?> disabled <?php } ?>>
                                                <option value="">Select</option>
                                                <?php 
                                                $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                                                $info = $obj_admin->manage_all_info($sql);
                                                while ($rows = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?php echo $rows['user_id']; ?>" <?php if ($rows['user_id'] == $row['t_user_id']) { ?> selected <?php } ?>><?php echo $rows['fullname']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Savings Plan</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="status" id="status" <?php if ($user_role != 1) { ?> disabled <?php } ?>>
                                                <option value="0" <?php if ($row['status'] == 0) { ?>selected<?php } ?>>Monthly</option>
                                                <option value="1" <?php if ($row['status'] == 1) { ?>selected<?php } ?>>Weekly</option>
                                                <option value="2" <?php if ($row['status'] == 2) { ?>selected<?php } ?>>Daily</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if ($user_role == 1) { // Show update button only for admin ?>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-3"></div>
                                        <div class="col-sm-3">
                                            <button type="submit" name="update_task_info" class="btn btn-success-custom">Update Now</button>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
flatpickr('#t_end_time', {
    enableTime: true
});
</script>
