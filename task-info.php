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


if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}

$page_name="Task_Info";
include("include/sidebar.php");
// include('ems_header.php');

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog add-category-modal">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center">New Savings Plan </h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" action="" method="post" autocomplete="off">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Customer's ID</label>
                                    <div class="col-sm-7">
                                        <input type="text" placeholder="Customer's ID" id="task_title" name="task_title" list="expense" class="form-control" id="default" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Phone Number</label>
                                    <div class="col-sm-7">
                                        <textarea name="task_description" id="task_description" placeholder="Phone Number" class="form-control" rows="5" cols="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Amount Saved</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="t_start_time" id="t_start_time" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Total Amount Saved</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="t_a" id="t_a" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Date</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="t_end_time" id="t_end_time" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Savings Status</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="t_a" id="t_sta" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">Customer</label>
                                    <div class="col-sm-7">
                                        <?php 
                        $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                        $info = $obj_admin->manage_all_info($sql);   
                      ?>
                                        <select class="form-control" name="assign_to" id="aassign_to" required>
                                            <option value="">Select Customer</option>

                                            <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                  
                                </div>
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-3">
                                        <button type="submit" name="add_task_post" class="btn btn-success-custom">Submit</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-danger-custom" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-8">
                    <div class="btn-group">
                        <?php if($user_role == 1){ ?>
                        <div class="btn-group">
                            <button class="btn btn-warning btn-menu" data-toggle="modal" data-target="#myModal">Add New Plan</button>
                        </div>
                        <?php } ?>

                    </div>

                </div>

       
            </div>
            <center>
                <h3>Savings Plan Management</h3>
            </center>
            <div class="gap"></div>

            <div class="gap"></div>

            <div class="table-responsive">
                <table class="table table-codensed table-custom">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Customer ID</th>
                            <th>Customer</th>
                            <th>Amount Saved</th>
                            <th>Total Amount Saved</th>
                            <th>Date</th>
                            <th>Savings Status</th> 
                            <th>Savings Plan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                if($user_role == 1){
                  $sql = "SELECT a.*, b.fullname 
                        FROM task_info a
                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                        ORDER BY a.task_id DESC";
                }else{
                  $sql = "SELECT a.*, b.fullname 
                  FROM task_info a
                  INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                  WHERE a.t_user_id = $user_id
                  ORDER BY a.task_id DESC";
                } 
                
                  $info = $obj_admin->manage_all_info($sql);
                  $serial  = 1;
                  $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                      while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                        <tr>
                            <td><?php echo $serial; $serial++; ?></td>
                            <td><?php echo $row['t_title']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['t_start_time']; ?></td>
                            <td><?php echo $row['t_a']; ?></td>
                            <td><?php echo $row['t_end_time']; ?></td>
                            <td><?php echo $row['t_sta']; ?></td>
                            <td>
                                <?php  if($row['status'] == 1){
                        echo "Weekly";
                    }elseif($row['status'] == 2){
                       echo "Daily";
                    }else{
                      echo "Monthly ";
                    } ?>

                            </td>

                            <td><a title="Update Records" href="edit-task.php?task_id=<?php echo $row['task_id'];?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                                <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>"><span class="glyphicon glyphicon-folder-open"></span></a>&nbsp;&nbsp;
                                <?php if($user_role == 1){ ?>
                                <a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php




?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">


flatpickr('#t_end_time', {
    enableTime: true
});
</script>
